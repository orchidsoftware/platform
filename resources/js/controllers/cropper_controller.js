import ApplicationController from "./application_controller";
import Cropper from 'cropperjs';

export default class extends ApplicationController {

    /**
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
        let image = this.data.get('url') ? this.data.get('url') : this.data.get(`value`);

        if (image) {
            this.element.querySelector('.cropper-preview').src = image;
        } else {
            this.element.querySelector('.cropper-preview').classList.add('none');
            this.element.querySelector('.cropper-remove').classList.add('none');
        }

        let cropPanel = this.element.querySelector('.upload-panel');

        cropPanel.width = this.data.get('width');
        cropPanel.height = this.data.get('height');

        this.cropper = new Cropper(cropPanel, {
            viewMode: 2,
            aspectRatio: this.data.get('width') / this.data.get('height'),
            minContainerHeight: 500,
        });
    }

    /**
     * Event for uploading image
     *
     * @param event
     */
    upload(event) {

        let maxFileSize = this.data.get('max-file-size');
        if (event.target.files[0].size / 1024 / 1024 > maxFileSize) {
            this.alert('Validation error', `The download file is too large. Max size: ${maxFileSize} MB`);
            event.target.value = null;
            return;
        }

        if (!event.target.files[0]) {
            $(this.element.querySelector('.modal')).modal('show');
            return;
        }

        let reader = new FileReader();
        reader.readAsDataURL(event.target.files[0]);

        reader.onloadend = () => {
            this.cropper.replace(reader.result)
        };

        $(this.element.querySelector('.modal')).modal('show');
    }

    /**
     *
     */
    openModal(event)
    {
        if (!event.target.files[0]) {
            return;
        }

        $(this.element.querySelector('.modal')).modal('show');
    }

    /**
     * Action on click button "Crop"
     */
    crop() {

        this.cropper.getCroppedCanvas({
            width: this.data.get('width'),
            height: this.data.get('height'),
            minWidth: this.data.get('min-width'),
            minHeight: this.data.get('min-height'),
            maxWidth: this.data.get('max-width'),
            maxHeight: this.data.get('max-height'),
            imageSmoothingQuality: 'medium',
        }).toBlob((blob) => {
            const formData = new FormData();

            formData.append('file', blob);
            formData.append('storage', this.data.get('storage'));
            formData.append('acceptedFiles', this.data.get('accepted-files'));

            let element = this.element;
             window.axios.post(this.prefix('/systems/files'), formData)
                .then((response) => {
                    let image = response.data.url;
                    let targetValue = this.data.get('target');

                    element.querySelector('.cropper-preview').src = image;
                    element.querySelector('.cropper-preview').classList.remove('none');
                    element.querySelector('.cropper-remove').classList.remove('none');
                    element.querySelector('.cropper-path').value = response.data[targetValue];

                    // add event for listener
                    element.querySelector('.cropper-path').dispatchEvent(new Event("change"));

                    $(element.querySelector('.modal')).modal('hide');
                })
                .catch((error) => {
                    this.alert('Validation error', 'File upload error');
                    console.warn(error);
                });
        });

    }

    /**
     *
     */
    clear() {
        this.element.querySelector('.cropper-path').value = '';
        this.element.querySelector('.cropper-preview').src = '';
        this.element.querySelector('.cropper-preview').classList.add('none');
        this.element.querySelector('.cropper-remove').classList.add('none');
    }

    /**
     * Action on click buttons
     */
    moveleft() {
        this.cropper.move(-10, 0);
    }

    moveright() {
        this.cropper.move(10, 0);
    }

    moveup() {
        this.cropper.move(0, -10);
    }

    movedown() {
        this.cropper.move(0, 10);
    }

    zoomin() {
        this.cropper.zoom(0.1);
    }

    zoomout() {
        this.cropper.zoom(-0.1);
    }

    rotateleft() {
        this.cropper.rotate(-5);
    }

    rotateright() {
        this.cropper.rotate(5);
    }

    scalex() {
        const dataScaleX = this.element.querySelector('.cropper-dataScaleX');
        this.cropper.scaleX(-dataScaleX.value);
    }

    scaley() {
        const dataScaleY = this.element.querySelector('.cropper-dataScaleY');
        this.cropper.scaleY(-dataScaleY.value)
    }

    aspectratiowh() {
        this.cropper.setAspectRatio(this.data.get('width') / this.data.get('height'));
    }

    aspectratiofree() {
        this.cropper.setAspectRatio(NaN);
    }

}
