import { css } from "@codemirror/lang-css";
import { html } from "@codemirror/lang-html";
import { javascript } from "@codemirror/lang-javascript";
import { defaultKeymap, history, historyKeymap, indentWithTab } from "@codemirror/commands";
import { HighlightStyle, bracketMatching, defaultHighlightStyle, syntaxHighlighting } from "@codemirror/language";
import { EditorState } from "@codemirror/state";
import {
    EditorView,
    drawSelection,
    highlightActiveLine,
    keymap,
    lineNumbers,
    placeholder,
} from "@codemirror/view";
import { tags } from "@lezer/highlight";
import ApplicationController from "./application_controller";

const markupHighlightStyle = HighlightStyle.define([
    { tag: tags.keyword, color: "#7c3aed", fontWeight: "600" },
    { tag: tags.string, color: "#15803d" },
    { tag: tags.number, color: "#0369a1" },
    { tag: tags.comment, color: "#6c757d", fontStyle: "italic" },
    { tag: tags.tagName, color: "#0f766e", fontWeight: "600" },
    { tag: tags.attributeName, color: "#b45309" },
    { tag: tags.attributeValue, color: "#15803d" },
    { tag: tags.variableName, color: "#1f2937" },
    { tag: tags.propertyName, color: "#2563eb" },
    { tag: tags.operator, color: "#6c757d" },
    { tag: tags.punctuation, color: "#6c757d" },
]);

const activeLineTheme = EditorView.theme({
    ".cm-activeLine": {
        backgroundColor: "transparent",
    },
    "&.cm-focused .cm-activeLine": {
        backgroundColor: "rgba(0, 0, 0, 0.04)",
    },
});

export default class extends ApplicationController {
    static targets = ["editor", "textarea"];

    static values = {
        language: { type: String, default: "js" },
        lineNumbers: { type: Boolean, default: true },
    };

    /**
     * Initializes the CodeMirror editor and synchronizes it with the form value.
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
                    syntaxHighlighting(defaultHighlightStyle, { fallback: true }),
                    syntaxHighlighting(markupHighlightStyle),
                    this.#languageExtension(),
                    this.#lineNumberExtension(),
                    activeLineTheme,
                    placeholder(this.#placeholder()),
                    keymap.of([indentWithTab, ...historyKeymap, ...defaultKeymap]),
                    EditorView.lineWrapping,
                    EditorView.editable.of(!this.textareaTarget.readOnly && !this.textareaTarget.disabled),
                    EditorView.updateListener.of(update => {
                        if (update.docChanged) {
                            this.textareaTarget.value = update.state.doc.toString();
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
     * Returns the configured placeholder for the hidden textarea.
     *
     * @returns {string}
     */
    #placeholder() {
        return this.textareaTarget.getAttribute("placeholder") || "";
    }

    /**
     * Enables line numbers when requested by the field.
     *
     * @returns {import("@codemirror/state").Extension}
     */
    #lineNumberExtension() {
        return this.lineNumbersValue ? lineNumbers() : [];
    }

    /**
     * Resolves a CodeMirror language extension from the field language.
     *
     * @returns {import("@codemirror/state").Extension}
     */
    #languageExtension() {
        switch (this.languageValue) {
            case "markup":
            case "html":
            case "xml":
            case "svg":
            case "mathml":
                return html();
            case "css":
                return css();
            case "json":
                return javascript();
            case "javascript":
            case "js":
            case "clike":
                return javascript();
            default:
                return javascript();
        }
    }
}
