import {Controller} from "stimulus"
import SimpleMDE from "simplemde";

export default class extends Controller {

    connect() {

        let textarea = this.element.querySelector('textarea');

        new SimpleMDE({
            autoDownloadFontAwesome: false,
            forceSync: true,
            element: textarea,
            toolbar: [
                {
                    name: "bold",
                    action: SimpleMDE.toggleBold,
                    className: "icon-bold",
                    title: "Bold",
                },
                {
                    name: "italic",
                    action: SimpleMDE.toggleItalic,
                    className: "icon-italic",
                    title: "Italic",
                },
                {
                    name: "heading",
                    action: SimpleMDE.toggleHeadingSmaller,
                    className: "icon-font",
                    title: "Heading",
                },
                '|',
                {
                    name: "quote",
                    action: SimpleMDE.toggleBlockquote,
                    className: "icon-quote",
                    title: "Quote",
                }, {
                    name: "code",
                    action: SimpleMDE.toggleCodeBlock,
                    className: "icon-code",
                    title: "Code",
                }, {
                    name: "unordered-list",
                    action: SimpleMDE.toggleUnorderedList,
                    className: "icon-list",
                    title: "Generic List",
                }, {
                    name: "ordered-list",
                    action: SimpleMDE.toggleOrderedList,
                    className: "icon-number-list",
                    title: "Numbered List",
                },
                '|',
                {
                    name: "link",
                    action: SimpleMDE.drawLink,
                    className: "icon-link",
                    title: "Link",
                },
                {
                    name: "image",
                    action: SimpleMDE.drawImage,
                    className: "icon-picture",
                    title: "Insert Image",
                },
                {
                    name: "table",
                    action: SimpleMDE.drawTable,
                    className: "icon-table",
                    title: "Insert Table",
                },
                '|',
                {
                    name: "preview",
                    action: SimpleMDE.togglePreview,
                    className: "icon-eye no-disable",
                    title: "Toggle Preview",
                }, {
                    name: "side-by-side",
                    action: SimpleMDE.toggleSideBySide,
                    className: "icon-browser no-disable no-mobile",
                    title: "Toggle Side by Side",
                }, {
                    name: "fullscreen",
                    action: SimpleMDE.toggleFullScreen,
                    className: "icon-full-screen no-disable no-mobile",
                    title: "Toggle Fullscreen",
                },
                '|',
                {
                    name: "horizontal-rule",
                    action: SimpleMDE.drawHorizontalRule,
                    className: "icon-options",
                    title: "Insert Horizontal Line",
                }, {
                    name: "guide",
                    action: "https://simplemde.com/markdown-guide",
                    className: "icon-help",
                    title: "Markdown Guide",
                },
            ],
            placeholder: textarea.placeholder,
            spellChecker: false,
        });
    }

}