import {Controller} from "stimulus";
import {Croppie}    from 'croppie';

export default class extends Controller {

    /**
     *
     * @type {string[]}
     */
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

        let cropPanel = this.element.querySelector('.upload-panel');
        this.croppie = new Croppie(cropPanel, {
            viewport: {
                width: this.data.get('width'),
                height: this.data.get('height'),
            },
            boundary: {
                width: '100%',
                height: 500
            },
            enforceBoundary: true
        });
    }

    /**
     * Event for uploading image
     *
     * @param event
     */
    upload(event) {

        if (!event.target.files[0]) {
            return;
        }

        let reader = new FileReader();
        reader.readAsDataURL(event.target.files[0]);

        reader.onloadend = () => {
            this.croppie.bind({
                url: reader.result
            });
        };

        $(this.element.querySelector('.modal')).modal('show');
    }

    /**
     * Action on click button "Crop"
     */
    crop() {

        this.croppie.result('result', {
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
