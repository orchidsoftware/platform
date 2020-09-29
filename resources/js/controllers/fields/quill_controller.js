import {Controller} from 'stimulus';
import Quill from 'quill';

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
                toolbar: {
                    container: this.data.get('toolbar') ? this.containerCustomToolbar() : this.containerToolbar(),
                },
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

        this.editor.getModule('toolbar').addHandler('color', (value) => {
            this.editor.format('color', this.customColor(value));
        });

        this.editor.getModule('toolbar').addHandler('background', (value) => {
            this.editor.format('background', this.customColor(value));
        });

    }

    /**
     * Show dialog for custom color
     *
     * @param value
     */
    customColor = (value) => {
        return value === 'custom-color'
            ? window.prompt('Enter Color Code (#c0ffee or rgba(255, 0, 0, 0.5))')
            : value;
    }

    colors() {
        return [
            '#000000', '#e60000', '#ff9900', '#ffff00', '#008a00', '#0066cc',
            '#9933ff', '#ffffff', '#facccc', '#ffebcc', '#ffffcc', '#cce8cc',
            '#cce0f5', '#ebd6ff', '#bbbbbb', '#f06666', '#ffc266', '#ffff66',
            '#66b966', '#66a3e0', '#c285ff', '#888888', '#a10000', '#b26b00',
            '#b2b200', '#006100', '#0047b2', '#6b24b2', '#444444', '#5c0000',
            '#663d00', '#666600', '#003700', '#002966', '#3d1466', 'custom-color'
        ];
    }

    containerToolbar() {
        return [
            ['bold', 'italic', 'underline', 'strike'],
            [{color: this.colors()}, {background: this.colors()}],
            [{header: '1'}, {header: '2'}, 'blockquote', 'code-block'],
            [{list: 'ordered'}, {list: 'bullet'}, {indent: '-1'}, {indent: '+1'}, {align: []}],
            ['link', 'image', 'video', 'clean'],
        ];
    }

    containerCustomToolbar() {
        const groups = JSON.parse(this.data.get("toolbar"));
        let container = [];
        if (groups.includes('text'))
            container.push(['bold', 'italic', 'underline', 'strike', 'link', 'clean'])
        if (groups.includes('color'))
            container.push([{color: this.colors()}, {background: this.colors()}])
        if (groups.includes('header'))
            container.push([{header: '1'}, {header: '2'}])
        if (groups.includes('list'))
            container.push([{list: 'ordered'}, {list: 'bullet'}])
        if (groups.includes('format'))
            container.push([{indent: '-1'}, {indent: '+1'}, {align: []}])
        if (groups.includes('media'))
            container.push(['image', 'video'])

        return container
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
