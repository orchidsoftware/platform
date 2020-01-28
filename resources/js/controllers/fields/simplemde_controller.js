import {Controller} from 'stimulus';
import SimpleMDE from 'simplemde';

export default class extends Controller {
    /**
     *
     * @returns {Element}
     */
    get textarea() {
        return this.element.querySelector('textarea');
    }

    /**
     *
     */
    get uploadInput() {
        return this.element.querySelector('.upload');
    }

    /**
     *
     */
    connect() {
        this.editor = new SimpleMDE({
            autoDownloadFontAwesome: false,
            forceSync: true,
            element: this.textarea,
            toolbar: [
                {
                    name: 'bold',
                    action: SimpleMDE.toggleBold,
                    className: 'icon-bold',
                    title: 'Bold',
                },
                {
                    name: 'italic',
                    action: SimpleMDE.toggleItalic,
                    className: 'icon-italic',
                    title: 'Italic',
                },
                {
                    name: 'heading',
                    action: SimpleMDE.toggleHeadingSmaller,
                    className: 'icon-font',
                    title: 'Heading',
                },
                '|',
                {
                    name: 'quote',
                    action: SimpleMDE.toggleBlockquote,
                    className: 'icon-quote',
                    title: 'Quote',
                }, {
                    name: 'code',
                    action: SimpleMDE.toggleCodeBlock,
                    className: 'icon-code',
                    title: 'Code',
                }, {
                    name: 'unordered-list',
                    action: SimpleMDE.toggleUnorderedList,
                    className: 'icon-list',
                    title: 'Generic List',
                }, {
                    name: 'ordered-list',
                    action: SimpleMDE.toggleOrderedList,
                    className: 'icon-number-list',
                    title: 'Numbered List',
                },
                '|',
                {
                    name: 'link',
                    action: SimpleMDE.drawLink,
                    className: 'icon-link',
                    title: 'Link',
                },
                {
                    name: 'image',
                    action: SimpleMDE.drawImage,
                    className: 'icon-picture',
                    title: 'Insert Image',
                }, {
                    name: 'upload',
                    action: () => this.showDialogUpload(),
                    className: 'icon-cloud-upload',
                    title: 'Upload File',
                },
                {
                    name: 'table',
                    action: SimpleMDE.drawTable,
                    className: 'icon-table',
                    title: 'Insert Table',
                },
                '|',
                {
                    name: 'preview',
                    action: SimpleMDE.togglePreview,
                    className: 'icon-eye no-disable',
                    title: 'Toggle Preview',
                }, {
                    name: 'side-by-side',
                    action: SimpleMDE.toggleSideBySide,
                    className: 'icon-browser no-disable no-mobile',
                    title: 'Toggle Side by Side',
                }, {
                    name: 'fullscreen',
                    action: SimpleMDE.toggleFullScreen,
                    className: 'icon-full-screen no-disable no-mobile',
                    title: 'Toggle Fullscreen',
                },
                '|',
                {
                    name: 'horizontal-rule',
                    action: SimpleMDE.drawHorizontalRule,
                    className: 'icon-options',
                    title: 'Insert Horizontal Line',
                }, {
                    name: 'guide',
                    action: () => this.showModal(),
                    className: 'icon-help',
                    title: 'Markdown Guide',
                },
            ],
            placeholder: this.textarea.placeholder,
            spellChecker: false,
        });

        // Required attribute https://github.com/sparksuite/simplemde-markdown-editor/issues/324
        if (this.textarea.required) {
            this.element.querySelector('.CodeMirror textarea').required = true;
        }
    }

    /**
     *
     * @returns {Element}
     */
    showModal() {
        $(this.element.querySelector('.modal')).modal('show');
    }

    /**
     *
     */
    showDialogUpload() {
        this.uploadInput.click();
    }

    /**
     *
     * @param event
     */
    upload(event) {
        const file = event.target.files[0];

        if (file === undefined || file === null) {
            return;
        }

        const formData = new FormData();
        formData.append('file', file);

        axios
            .post(platform.prefix('/systems/files'), formData)
            .then((response) => {
                this.editor.codemirror.replaceSelection(response.data.url);
                event.target.value = null;
            })
            .catch((error) => {
                console.warn(error);
                event.target.value = null;
            });
    }
}
