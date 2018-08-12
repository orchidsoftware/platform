import {Controller} from "stimulus";

export default class extends Controller {

    static targets = [
        "source",
        "upload"
    ];

    /**
     *
     */
    connect() {
        let image = this.data.get('image');

        if (image) {
            this.element.querySelector('.picture-preview').src = image;
        } else {
            this.element.querySelector('.picture-preview').classList.add('none');
            this.element.querySelector('.picture-remove').classList.add('none');
        }
    }

    /**
     * Event for uploading image
     *
     * @param event
     */
    upload(event) {

        let cropPanel = this.element.querySelector('.upload-panel');
        $(cropPanel).croppie('destroy');

        if (!event.target.files[0]) {
            return;
        }

        let width = this.data.get('width');
        let height = this.data.get('height');
        $(cropPanel).croppie({
            viewport: {
                width: width,
                height: height,
            },
            boundary: {
                width: '100%',
                height: 500
            },
            enforceBoundary: true
        });


        let reader = new FileReader();
        reader.readAsDataURL(event.target.files[0]);

        reader.onloadend = () => {
            $(cropPanel).croppie('bind', {
                url: reader.result
            });
        };

        $(this.element.querySelector('.modal')).modal('show');
    }

    /**
     * Action on click button "Crop"
     */
    crop() {

        let cropPanel = this.element.querySelector('.upload-panel');

        $(cropPanel).croppie('result', {
            type: 'blob',
            size: 'viewport',
            format: 'png'
        }).then(blob => {

            let data = new FormData();
            data.append('file', blob);
            data.append('storage', 'public');

            let element = this.element;
            axios.post(platform.prefix('/systems/files'), data)
                .then((response) => {

                    let image = `/storage/${response.data.path}${response.data.name}.${response.data.extension}`;

                    element.querySelector('.picture-preview').src = image;
                    element.querySelector('.picture-preview').classList.remove('none');
                    element.querySelector('.picture-remove').classList.remove('none');
                    element.querySelector('.picture-path').value = image;
                    $(element.querySelector('.modal')).modal('hide');
                });
        });
    }

    /**
     *
     */
    clear() {
        this.element.querySelector('.picture-path').value = '';
        this.element.querySelector('.picture-preview').src = '';
        this.element.querySelector('.picture-preview').classList.add('none');
        this.element.querySelector('.picture-remove').classList.add('none');
    }
}