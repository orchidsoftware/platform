import { markdown } from "@codemirror/lang-markdown";
import {
    defaultKeymap,
    history,
    historyKeymap,
    indentWithTab,
} from "@codemirror/commands";
import {
    HighlightStyle,
    bracketMatching,
    syntaxHighlighting,
} from "@codemirror/language";
import { EditorState, RangeSetBuilder, StateField } from "@codemirror/state";
import { tags } from "@lezer/highlight";
import {
    Decoration,
    EditorView,
    ViewPlugin,
    drawSelection,
    highlightActiveLine,
    keymap,
    placeholder,
} from "@codemirror/view";
import ApplicationController from "./application_controller";
import { uploadFile } from "../helpers/upload";

const markdownHighlightStyle = HighlightStyle.define([
    { tag: tags.heading1, class: "cm-md-token-heading-1" },
    { tag: tags.heading2, class: "cm-md-token-heading-2" },
    { tag: tags.heading3, class: "cm-md-token-heading-3" },
    { tag: tags.heading4, class: "cm-md-token-heading-4" },
    { tag: tags.heading5, class: "cm-md-token-heading-5" },
    { tag: tags.heading6, class: "cm-md-token-heading-5" },
    { tag: tags.strong, class: "cm-md-token-strong" },
    { tag: tags.emphasis, class: "cm-md-token-emphasis" },
    { tag: tags.link, class: "cm-md-token-link" },
    { tag: tags.url, class: "cm-md-token-url" },
    { tag: tags.quote, class: "cm-md-token-quote" },
    { tag: tags.monospace, class: "cm-md-token-code" },
    { tag: tags.contentSeparator, class: "cm-md-token-separator" },
    { tag: tags.processingInstruction, class: "cm-md-token-markup" },
]);

const activeLineTheme = EditorView.theme({
    ".cm-activeLine": {
        backgroundColor: "transparent",
    },
    "&.cm-focused .cm-activeLine": {
        backgroundColor: "rgba(0, 0, 0, 0.04)",
    },
});

const headingLineDecorations = StateField.define({
    create(state) {
        return buildHeadingLineDecorations(state.doc);
    },
    update(decorations, transaction) {
        if (!transaction.docChanged) {
            return decorations;
        }

        return buildHeadingLineDecorations(transaction.newDoc);
    },
    provide(field) {
        return EditorView.decorations.from(field);
    },
});

const markdownMarkerDecorations = ViewPlugin.fromClass(
    class {
        constructor(view) {
            this.decorations = buildMarkdownMarkerDecorations(view);
        }

        update(update) {
            if (update.docChanged || update.viewportChanged) {
                this.decorations = buildMarkdownMarkerDecorations(update.view);
            }
        }
    },
    {
        decorations: value => value.decorations,
    }
);

/**
 * Builds line decorations used to scale markdown heading rows.
 *
 * @param {import("@codemirror/state").Text} doc
 * @returns {import("@codemirror/state").RangeSet<Decoration>}
 */
function buildHeadingLineDecorations(doc) {
    const builder = new RangeSetBuilder();

    for (let index = 1; index <= doc.lines; index++) {
        const line = doc.line(index);
        const level = line.text.match(/^(#{1,5})\s/);

        if (level === null) {
            continue;
        }

        builder.add(
            line.from,
            line.from,
            Decoration.line({ class: `cm-md-heading-${level[1].length}` })
        );
    }

    return builder.finish();
}

/**
 * Builds token decorations for markdown markers not fully covered by tags.
 *
 * @param {EditorView} view
 * @returns {import("@codemirror/state").RangeSet<Decoration>}
 */
function buildMarkdownMarkerDecorations(view) {
    const builder = new RangeSetBuilder();
    const marker = Decoration.mark({ class: "cm-md-marker" });
    const codeFence = Decoration.mark({ class: "cm-md-code-fence" });

    for (const { from, to } of view.visibleRanges) {
        let position = from;

        while (position <= to) {
            const line = view.state.doc.lineAt(position);
            const text = line.text;

            [
                /^(#{1,5})(?=\s)/,
                /^(\s*>)(?=\s|$)/,
                /^(\s*[-*+])(?=\s|$)/,
            ].forEach(pattern => {
                const match = text.match(pattern);

                if (match !== null) {
                    builder.add(line.from, line.from + match[1].length, marker);
                }
            });

            const fence = text.match(/^(```+)(.*)$/);

            if (fence !== null) {
                builder.add(line.from, line.from + fence[0].length, codeFence);
            }

            if (line.to >= to) {
                break;
            }

            position = line.to + 1;
        }
    }

    return builder.finish();
}

export default class extends ApplicationController {
    static targets = ["editor", "textarea"];

    /**
     * Initializes the CodeMirror markdown editor and form synchronization.
     */
    connect() {
        this.view = new EditorView({
            parent: this.editorTarget,
            state: EditorState.create({
                doc: this.textareaTarget.value,
                extensions: [
                    history(),
                    drawSelection(),
                    highlightActiveLine(),
                    bracketMatching(),
                    syntaxHighlighting(markdownHighlightStyle),
                    markdown(),
                    activeLineTheme,
                    headingLineDecorations,
                    markdownMarkerDecorations,
                    placeholder(this.#placeholder()),
                    keymap.of([
                        indentWithTab,
                        ...historyKeymap,
                        ...defaultKeymap,
                    ]),
                    EditorView.domEventHandlers({
                        paste: event => this.#paste(event),
                    }),
                    EditorView.lineWrapping,
                    EditorView.editable.of(
                        !this.textareaTarget.readOnly &&
                            !this.textareaTarget.disabled
                    ),
                    EditorView.updateListener.of(update => {
                        if (update.docChanged) {
                            this.textareaTarget.value =
                                update.state.doc.toString();
                        }
                    }),
                ],
            }),
        });
    }

    /**
     * Destroys the CodeMirror instance when Stimulus disconnects.
     */
    disconnect() {
        this.view?.destroy();
    }

    /**
     * Toggles an H1 markdown prefix on the selected line range.
     */
    headingOne() {
        this.#toggleLinePrefix("# ");
    }

    /**
     * Toggles an H2 markdown prefix on the selected line range.
     */
    headingTwo() {
        this.#toggleLinePrefix("## ");
    }

    /**
     * Toggles an H3 markdown prefix on the selected line range.
     */
    headingThree() {
        this.#toggleLinePrefix("### ");
    }

    /**
     * Toggles an H4 markdown prefix on the selected line range.
     */
    headingFour() {
        this.#toggleLinePrefix("#### ");
    }

    /**
     * Toggles an H5 markdown prefix on the selected line range.
     */
    headingFive() {
        this.#toggleLinePrefix("##### ");
    }

    /**
     * Wraps the current selection in markdown bold markers.
     */
    bold() {
        this.#wrapSelection("**", "**", "bold text");
    }

    /**
     * Wraps the current selection in markdown italic markers.
     */
    italic() {
        this.#wrapSelection("*", "*", "italic text");
    }

    /**
     * Wraps the current selection in markdown link syntax.
     */
    link() {
        this.#wrapSelection("[", "](https://)", "link text");
    }

    /**
     * Toggles a markdown blockquote prefix on the selected line range.
     */
    quote() {
        this.#toggleLinePrefix("> ");
    }

    /**
     * Wraps the current selection in a fenced markdown code block.
     */
    code() {
        this.#wrapSelection("```\n", "\n```", "");
    }

    /**
     * Toggles an unordered markdown list prefix on the selected line range.
     */
    list() {
        this.#toggleLinePrefix("- ");
    }

    /**
     * Toggles an ordered markdown list prefix on the selected line range.
     */
    orderedList() {
        this.#toggleLinePrefix("1. ");
    }

    /**
     * Opens the hidden file input used by the upload button.
     */
    showDialogUpload() {
        this.element.querySelector(".upload").click();
    }

    /**
     * Uploads the selected file and inserts it as markdown image syntax.
     *
     * @param {Event} event
     */
    upload(event) {
        const file = event.target.files[0];

        if (file === undefined || file === null) {
            return;
        }

        uploadFile(this.prefix("/files"), file)
            .then(data => {
                this.#insertText(`![](${data.url})`);
                event.target.value = null;
            })
            .catch(error => {
                console.warn(error);
                event.target.value = null;
            });
    }

    /**
     * Returns the configured placeholder for the hidden textarea.
     *
     * @returns {string}
     */
    #placeholder() {
        return this.textareaTarget.getAttribute("placeholder") || "";
    }

    /**
     * Normalizes pasted markdown before inserting it into the editor.
     *
     * @param {ClipboardEvent} event
     * @returns {boolean}
     */
    #paste(event) {
        const clipboard = this.#readClipboard(event);
        const text = this.#getClipboardText(clipboard);

        if (text === undefined || text === null || text.length === 0) {
            return false;
        }

        event.preventDefault();
        this.#insertText(this.#normalizePastedText(text));

        return true;
    }

    /**
     * Reads plain and HTML clipboard payloads.
     *
     * @param {ClipboardEvent} event
     * @returns {{plain: string, html: string}}
     */
    #readClipboard(event) {
        const clipboardData = event.clipboardData;

        return {
            plain: clipboardData?.getData("text/plain") || "",
            html: clipboardData?.getData("text/html") || "",
        };
    }

    /**
     * Chooses the cleanest available clipboard text representation.
     *
     * @param {{plain: string, html: string}} clipboard
     * @returns {string}
     */
    #getClipboardText(clipboard) {
        const html = clipboard.html;

        if (html !== undefined && html !== null && html.trim() !== "") {
            const text = this.#textFromClipboardHtml(html);

            if (text.trim() !== "") {
                return text;
            }
        }

        return clipboard.plain;
    }

    /**
     * Extracts text from HTML clipboard payloads without browser block noise.
     *
     * @param {string} html
     * @returns {string}
     */
    #textFromClipboardHtml(html) {
        const template = document.createElement("template");
        template.innerHTML = html;

        const code = template.content.querySelector("pre, code");

        if (code !== null) {
            return code.textContent;
        }

        return Array.from(
            template.content.querySelectorAll(
                "p, h1, h2, h3, h4, h5, h6, li, blockquote"
            )
        )
            .map(element => element.textContent.trim())
            .filter(Boolean)
            .join("\n\n");
    }

    /**
     * Normalizes pasted markdown text and unwraps hard-wrapped paragraphs.
     *
     * @param {string} text
     * @returns {string}
     */
    #normalizePastedText(text) {
        const normalized = text
            .replace(/\r\n?/g, "\n")
            .replace(/\u00a0/g, " ")
            .split("\n")
            .map(line => line.replace(/[ \t]+$/g, ""))
            .join("\n");

        return this.#unwrapMarkdownParagraphs(
            normalized.replace(/\n[ \t]+\n/g, "\n\n").replace(/\n{3,}/g, "\n\n")
        );
    }

    /**
     * Unwraps ordinary hard-wrapped markdown paragraphs.
     *
     * @param {string} text
     * @returns {string}
     */
    #unwrapMarkdownParagraphs(text) {
        return text
            .split(/\n{2,}/)
            .map(block => this.#unwrapMarkdownBlock(block))
            .join("\n\n");
    }

    /**
     * Unwraps a single markdown block when it is safe to do so.
     *
     * @param {string} block
     * @returns {string}
     */
    #unwrapMarkdownBlock(block) {
        const lines = block.split("\n");

        if (lines.length < 2 || this.#isPreformattedMarkdownBlock(lines)) {
            return block;
        }

        return lines.join(" ");
    }

    /**
     * Checks whether a block must preserve hard line breaks.
     *
     * @param {string[]} lines
     * @returns {boolean}
     */
    #isPreformattedMarkdownBlock(lines) {
        const firstLine = lines[0] ?? "";

        return (
            /^ {4,}|\t/.test(firstLine) ||
            /^```|^~~~/.test(firstLine) ||
            /^#{1,6}\s/.test(firstLine) ||
            /^>\s?/.test(firstLine) ||
            /^([-*+]|\d+\.)\s/.test(firstLine) ||
            /^\|.*\|$/.test(firstLine) ||
            /^-{3,}$|^\*{3,}$|^_{3,}$/.test(firstLine)
        );
    }

    /**
     * Replaces the current selection with wrapped markdown text.
     *
     * @param {string} before
     * @param {string} after
     * @param {string} placeholder
     * @param {{cursor?: Function}} options
     */
    #wrapSelection(before, after, placeholder, options = {}) {
        const selection = this.view.state.selection.main;
        const selected = this.view.state.sliceDoc(selection.from, selection.to);
        const content = selected || placeholder;
        const text = `${before}${content}${after}`;
        const cursor =
            typeof options.cursor === "function"
                ? options.cursor({
                      from: selection.from + before.length,
                      content,
                      selected,
                  })
                : selection.from + text.length;

        this.view.dispatch({
            changes: { from: selection.from, to: selection.to, insert: text },
            selection: { anchor: cursor },
            scrollIntoView: true,
        });
        this.view.focus();
    }

    /**
     * Toggles a prefix across every selected line.
     *
     * @param {string} prefix
     */
    #toggleLinePrefix(prefix) {
        const selection = this.view.state.selection.main;
        const changes = [];
        let offset = 0;

        for (let position = selection.from; position <= selection.to; ) {
            const line = this.view.state.doc.lineAt(position);
            const text = line.text;

            if (text.startsWith(prefix)) {
                changes.push({
                    from: line.from,
                    to: line.from + prefix.length,
                    insert: "",
                });
                offset -= prefix.length;
            } else {
                changes.push({ from: line.from, insert: prefix });
                offset += prefix.length;
            }

            if (line.to >= selection.to) {
                break;
            }

            position = line.to + 1;
        }

        this.view.dispatch({
            changes,
            selection: {
                anchor: Math.max(selection.from, selection.to + offset),
            },
            scrollIntoView: true,
        });
        this.view.focus();
    }

    /**
     * Inserts text at the current selection and focuses the editor.
     *
     * @param {string} text
     */
    #insertText(text) {
        const selection = this.view.state.selection.main;

        this.view.dispatch({
            changes: { from: selection.from, to: selection.to, insert: text },
            selection: { anchor: selection.from + text.length },
            scrollIntoView: true,
        });
        this.view.focus();
    }
}
