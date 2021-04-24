import ApplicationController from "./application_controller";
import SimpleMDE from 'simplemde';

export default class extends ApplicationController {

    static values = { text: String }

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
            // Defaults to undefined, which will intelligently check whether
            // Font Awesome has already been included, then download accordingly.
            autoDownloadFontAwesome: undefined,
            forceSync: true,
            element: this.textarea,
            toolbar: [
                {
                    name: 'bold',
                    action: SimpleMDE.toggleBold,
                    className: 'fa fa-bold',
                    title: 'Bold',
                },
                {
                    name: 'italic',
                    action: SimpleMDE.toggleItalic,
                    className: 'fa fa-italic',
                    title: 'Italic',
                },
                {
                    name: 'heading',
                    action: SimpleMDE.toggleHeadingSmaller,
                    className: 'fa fa-header',
                    title: 'Heading',
                },
                '|',
                {
                    name: 'quote',
                    action: SimpleMDE.toggleBlockquote,
                    className: 'fa fa-quote-left',
                    title: 'Quote',
                }, {
                    name: 'code',
                    action: SimpleMDE.toggleCodeBlock,
                    className: 'fa fa-code',
                    title: 'Code',
                }, {
                    name: 'unordered-list',
                    action: SimpleMDE.toggleUnorderedList,
                    className: 'fa fa-list-ul',
                    title: 'Generic List',
                }, {
                    name: 'ordered-list',
                    action: SimpleMDE.toggleOrderedList,
                    className: 'fa fa-list-ol',
                    title: 'Numbered List',
                },
                '|',
                {
                    name: 'link',
                    action: SimpleMDE.drawLink,
                    className: 'fa fa-link',
                    title: 'Link',
                },
                {
                    name: 'image',
                    action: SimpleMDE.drawImage,
                    className: 'fa fa-picture-o',
                    title: 'Insert Image',
                }, {
                    name: 'upload',
                    action: () => this.showDialogUpload(),
                    className: 'fa fa-upload',
                    title: 'Upload File',
                },
                {
                    name: 'table',
                    action: SimpleMDE.drawTable,
                    className: 'fa fa-table',
                    title: 'Insert Table',
                },
                '|',
                {
                    name: 'preview',
                    action: SimpleMDE.togglePreview,
                    className: 'fa fa-eye no-disable',
                    title: 'Toggle Preview',
                }, {
                    name: 'side-by-side',
                    action: SimpleMDE.toggleSideBySide,
                    className: 'fa fa-columns no-disable no-mobile',
                    title: 'Toggle Side by Side',
                }, {
                    name: 'fullscreen',
                    action: SimpleMDE.toggleFullScreen,
                    className: 'fa fa-arrows-alt no-disable no-mobile',
                    title: 'Toggle Fullscreen',
                },
                '|',
                {
                    name: 'horizontal-rule',
                    action: SimpleMDE.drawHorizontalRule,
                    className: 'fa fa-minus',
                    title: 'Insert Horizontal Line',
                },
            ],
            initialValue: this.decodeHtmlJson(this.textValue),
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
     * @param json
     * @returns {string}
     */
    decodeHtmlJson(json) {
        let text = document.createElement("textarea");
        text.innerHTML = JSON.parse(json);

        return text.value;
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
            .post(this.prefix('/systems/files'), formData)
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
