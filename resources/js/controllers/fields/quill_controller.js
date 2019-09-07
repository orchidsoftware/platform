import {Controller} from 'stimulus';
import Quill        from 'quill';

export default class extends Controller {
    /**
     *
     */
    connect() {
        const selector = this.element.querySelector('.quill').id;
        const input = this.element.querySelector('input');

        this.editor = new Quill(`#${selector}`, {
            placeholder: input.placeholder,
            readOnly: input.readOnly,
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ header: '1' }, { header: '2' }, 'blockquote', 'code-block'],
                    [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }, { align: [] }],
                    ['link', 'image', 'video', 'clean'],
                ],
            },
        });

        // quill editor add image handler
        this.editor.getModule('toolbar').addHandler('image', () => {
            this.selectLocalImage();
        });

        // set value
        // editor.setText(input.value);
        this.editor.root.innerHTML = input.value;

        // save value
        this.editor.on('text-change', () => {
            input.value = this.editor.getText() ? this.editor.root.innerHTML : '';
        });
    }

    /**
     * Step1. select local image
     *
     */
    selectLocalImage() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.click();

        // Listen upload local image and save to server
        input.onchange = () => {
            const file = input.files[0];

            // file type is only image.
            if (/^image\//.test(file.type)) {
                this.saveToServer(file);
            } else {
                window.platform.alert('Validation error', 'You could only upload images.', 'danger');
                console.warn('You could only upload images.');
            }
        };
    }

    /**
     * Step2. save to server
     *
     * @param {File} file
     */
    saveToServer(file) {
        const formData = new FormData();
        formData.append('image', file);

        axios
            .post(platform.prefix('/systems/files'), formData)
            .then((response) => {
                this.insertToEditor(response.data.url);
            })
            .catch((error) => {
                window.platform.alert('Validation error', 'Quill image upload failed');
                console.warn('quill image upload failed');
                console.warn(error);
            });
    }

    /**
     * Step3. insert image url to rich editor.
     *
     * @param {string} url
     */
    insertToEditor(url) {
        // push image url to rich editor.
        const range = this.editor.getSelection();
        this.editor.insertEmbed(range.index, 'image', url);
    }
}
