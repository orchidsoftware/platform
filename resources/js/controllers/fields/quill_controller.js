import {Controller} from 'stimulus';
import Quill        from 'quill';

export default class extends Controller {
    /**
     *
     */
    connect() {
        const selector = this.element.querySelector('.quill').id;
        const input = this.element.querySelector('input');

        let editor = new Quill(`#${selector}`, {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{'header': '1'}, {'header': '2'}, 'blockquote', 'code-block'],
                    [{'list': 'ordered'}, {'list': 'bullet'}, {'indent': '-1'}, {'indent': '+1'}, {'align': []}],
                    ['link', 'image', 'video', 'clean'],
                ]
            },
            placeholder: 'Compose an epic...',
        });

        /**
         * Step1. select local image
         *
         */
        function selectLocalImage() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.click();

            // Listen upload local image and save to server
            input.onchange = () => {
                const file = input.files[0];

                // file type is only image.
                if (/^image\//.test(file.type)) {
                    saveToServer(file);
                } else {
                    console.warn('You could only upload images.');
                }
            };
        }

        /**
         * Step2. save to server
         *
         * @param {File} file
         */
        function saveToServer(file) {
            const formData = new FormData();
            formData.append('image', file);

            axios
                .post(platform.prefix('/systems/files'), formData)
                .then(response => {
                    insertToEditor(response.data.url);
                })
                .catch(error => {
                    console.warn('quill image upload failed');
                    console.warn(error);
                });
        }

        /**
         * Step3. insert image url to rich editor.
         *
         * @param {string} url
         */
        function insertToEditor(url) {
            // push image url to rich editor.
            const range = editor.getSelection();
            editor.insertEmbed(range.index, 'image', url);
        }

        // quill editor add image handler
        editor.getModule('toolbar').addHandler('image', () => {
            selectLocalImage();
        });

        //set value
        editor.setText(input.value);

        //save value
        editor.on('text-change', () => {
            input.value = editor.getText() ? editor.root.innerHTML : '';
        });
    }
}