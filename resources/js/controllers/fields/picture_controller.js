import {Controller} from "stimulus";
import Cropper  from 'cropperjs';

export default class extends Controller {

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
        let image = this.data.get('image');

        if (image) {
            this.element.querySelector('.picture-preview').src = image;
        } else {
            this.element.querySelector('.picture-preview').classList.add('none');
            this.element.querySelector('.picture-remove').classList.add('none');
        }

        let cropPanel = this.element.querySelector('.upload-panel');
        var previews = this.element.querySelectorAll('.preview');

        var dataX = this.element.querySelector('.picture-dataX');
        var dataY = this.element.querySelector('.picture-dataY');
        var dataHeight = this.element.querySelector('.picture-dataHeight');
        var dataWidth = this.element.querySelector('.picture-dataWidth');
        var dataRotate = this.element.querySelector('.picture-dataRotate');
        var dataScaleX = this.element.querySelector('.picture-dataScaleX');
        var dataScaleY = this.element.querySelector('.picture-dataScaleY');

        cropPanel.width = this.data.get('width');
        cropPanel.height = this.data.get('height');


        this.cropper = new Cropper(cropPanel, {
            aspectRatio: this.data.get('width') / this.data.get('height'),
            preview: '.preview',

            ready: function () {
                console.log("ready");
            },
            crop: function (event) {

                var data = event.detail;
                dataX.value = Math.round(data.x);
                dataY.value = Math.round(data.y);
                dataHeight.value = Math.round(data.height);
                dataWidth.value = Math.round(data.width);
                dataRotate.value = typeof data.rotate !== 'undefined' ? data.rotate : '';
                dataScaleX.value = typeof data.scaleX !== 'undefined' ? data.scaleX : '';
                dataScaleY.value = typeof data.scaleY !== 'undefined' ? data.scaleY : '';

            }
        });

        let cropper = this.cropper;

        $(this.element.querySelectorAll('.picture-datas')).bind("change", function () {
            cropper.setData({
                x: Math.round(dataX.value),
                y: Math.round(dataY.value),
                width: Math.round(dataWidth.value),
                height: Math.round(dataHeight.value),
                rotate: Math.round(dataRotate.value),
                scaleX: Math.round(dataScaleX.value),
                scaleY: Math.round(dataScaleY.value)
            });
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
            this.cropper.replace(reader.result)
        };
        $(this.element.querySelector('.modal')).modal('show');
    }

    /**
     * Action on click button "Crop"
     */
    crop() {

        this.cropper.getCroppedCanvas({
            width: this.data.get('width'),
            height: this.data.get('height'),
            imageSmoothingQuality: 'medium'
        }).toBlob((blob) => {
            const formData = new FormData();

            formData.append('file', blob);
            formData.append('storage', 'public');

            let element = this.element;
            axios.post(platform.prefix('/systems/files'), formData)
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
        var dataScaleX = this.element.querySelector('.picture-dataScaleX');
        this.cropper.scaleX(-dataScaleX.value);
    }

    scaley() {
        var dataScaleY = this.element.querySelector('.picture-dataScaleY');
        this.cropper.scaleY(-dataScaleY.value)
    }

    aspectratiowh() {
        this.cropper.setAspectRatio(this.data.get('width') / this.data.get('height'));
    }

    aspectratiofree() {
        this.cropper.setAspectRatio(NaN);
    }

}