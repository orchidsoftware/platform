import ApplicationController from "./application_controller";
import SimpleMDE from 'simplemde/dist/simplemde.min';

export default class extends ApplicationController {

    static values = { text: String }

    /**
     * Returns the <textarea> element within the current controller element.
     *
     * @returns {Element}
     */
    get textarea() {
        return this.element.querySelector('textarea');
    }

    /**
     * Returns the input element with the 'upload' class within the current controller element.
     *
     * @returns {Element}
     */
    get uploadInput() {
        return this.element.querySelector('.upload');
    }

    /**
     * Initializes the controller and sets up visibility tracking to
     * only initialize the editor when the element comes into view.
     */
    initialize() {
        this.intersectionObserver = new IntersectionObserver((entries) => this.processIntersectionEntries(entries));
        this.intersectionObserver.observe(this.element);
    }

    /**
     * Handles IntersectionObserver entries. Initializes the SimpleMDE editor
     * when the element becomes visible.
     *
     * @param {IntersectionObserverEntry[]} entries - Array of intersection observer entries.
     */
    processIntersectionEntries(entries) {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            this.intersectionObserver.unobserve(this.element);
            this.editor = this.initEditor();
        });
    }

    /**
     * Initializes the SimpleMDE editor with configuration and content synchronization.
     *
     * @returns {SimpleMDE} Returns the initialized SimpleMDE instance.
     */
    initEditor() {
        const editor = new SimpleMDE({
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
            initialValue: JSON.parse(this.textValue),
            placeholder: this.textarea.placeholder,
            spellChecker: false,
        });

        return editor;
    }

    /**
     * Opens the file selection dialog.
     */
    showDialogUpload() {
        this.uploadInput.click();
    }


    /**
     * Handles file upload, sends the file to the server, and inserts the file URL into the editor.
     *
     * @param {Event} event - The file upload event.
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
                event.target.value = null; // Reset input after upload
            })
            .catch((error) => {
                console.warn(error);
                event.target.value = null; // Reset input after upload
            });
    }
}
