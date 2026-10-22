import ApplicationController from "./application_controller";
import { uploadFile } from "../helpers/upload";

const DEFAULT_BLOCK = Object.freeze({ type: "paragraph", text: "", html: "" });

const BLOCKS = Object.freeze({
    paragraph: { title: "Paragraph", shortcut: "Text" },
    heading: { title: "Heading", shortcut: "H2" },
    quote: { title: "Quote", shortcut: "Quote" },
    list: { title: "List", shortcut: "List" },
    image: { title: "Image", shortcut: "Image" },
    code: { title: "Code", shortcut: "Code" },
    embed: { title: "Embed", shortcut: "Embed" },
});

const HEADING_LEVELS = Object.freeze([1, 2, 3, 4, 5, 6]);
const RICH_TEXT_BLOCKS = new Set(["paragraph", "quote"]);
const INLINE_BUTTONS = Object.freeze([
    ["bold", "B"],
    ["italic", "I"],
    ["link", "Link"],
]);
const INLINE_TAGS = new Set([
    "A",
    "B",
    "BR",
    "CODE",
    "EM",
    "I",
    "S",
    "STRONG",
    "U",
]);
const PLACEHOLDERS = Object.freeze({
    paragraph: "Write a thought, note, or story",
    heading: "Name this section",
    quote: "Add a quote worth remembering",
    list: "Add the first item",
    image: "Upload an image",
    code: "Paste code here",
    embed: "Paste a video or embed link",
});

export default class extends ApplicationController {
    static targets = ["canvas", "textarea"];

    static values = {
        readonly: Boolean,
        disabled: Boolean,
        tools: Array,
    };

    connect() {
        this.documentData = null;
        this.blocks = this.#parseBlocks(this.textareaTarget.value);
        this.uploads = new WeakMap();
        this.connected = true;
        this.pendingLinkRange = null;
        this.pendingLinkAnchor = null;

        this.#render();
    }

    disconnect() {
        this.connected = false;
        this.pendingLinkRange = null;
        this.pendingLinkAnchor = null;
    }

    insertParagraph(event) {
        event?.preventDefault();

        if (!this.#canEdit() || !this.#hasTools()) {
            return;
        }

        this.#insertAt(
            this.#insertIndexFromEvent(event),
            this.#newBlock(
                this.#availableTypes().includes("paragraph")
                    ? "paragraph"
                    : this.#availableTypes()[0]
            )
        );
    }

    changeType(event) {
        if (!this.#canEdit()) {
            return;
        }

        if (
            this.#availableTypes().includes(event.target.value) &&
            this.blocks[this.#blockIndex(event)]?.type !== event.target.value
        ) {
            this.#replaceBlock(event, block =>
                this.#convertBlock(block, event.target.value)
            );
        }
    }

    changeHeadingLevel(event) {
        if (!this.#canEdit()) {
            return;
        }

        this.#patchBlock(
            event,
            block =>
                block.type === "heading"
                    ? { level: this.#headingLevel(event.target.value) }
                    : null,
            { render: true }
        );
    }

    formatInline(event) {
        event.preventDefault();

        if (!this.#canEdit()) {
            return;
        }

        const editable = this.#focusedEditable();
        const command = event.currentTarget.dataset.inlineCommand;

        if (!editable || !command) {
            return;
        }

        if (command === "link") {
            this.#openLinkEditor(editable);
            return;
        }

        document.execCommand(command, false);
        this.#syncEditable(editable);
    }

    applyLink(event) {
        event.preventDefault();

        if (!this.#canEdit()) {
            return;
        }

        const linkEditor = this.#linkEditorFromEvent(event);
        const editable = this.#editableForLinkEditor(linkEditor);
        const url = this.#linkUrl(
            linkEditor?.querySelector("[data-link-url='true']")?.value
        );

        if (!editable || !url) {
            return;
        }

        this.#writeLink(url);
        this.#closeLinkEditor();
        this.#syncEditable(editable);
        editable.focus();
    }

    unlink(event) {
        event.preventDefault();

        if (!this.#canEdit()) {
            return;
        }

        const linkEditor = this.#linkEditorFromEvent(event);
        const editable = this.#editableForLinkEditor(linkEditor);

        if (this.pendingLinkAnchor) {
            this.pendingLinkAnchor.replaceWith(
                document.createTextNode(
                    this.pendingLinkAnchor.textContent ?? ""
                )
            );
        } else {
            document.execCommand("unlink", false);
        }

        this.#closeLinkEditor();

        if (editable) {
            this.#syncEditable(editable);
            editable.focus();
        }
    }

    cancelLink(event) {
        event.preventDefault();
        this.#closeLinkEditor();
    }

    deleteBlock(event) {
        event?.preventDefault();

        if (!this.#canEdit()) {
            return;
        }

        const index = this.#blockIndex(event);

        if (index !== null) {
            this.#deleteAt(index);
        }
    }

    updateText(event) {
        if (!this.#canEdit()) {
            return;
        }

        this.#patchBlock(event, {
            text: event.target.textContent ?? "",
            html: this.#sanitizeInlineHtml(event.target.innerHTML),
        });
    }

    updateList(event) {
        const items = Array.from(event.target.querySelectorAll("li")).map(
            item => item.textContent ?? ""
        );

        this.#patchBlock(event, { items: this.#compactListItems(items) });
    }

    chooseImage(event) {
        event.preventDefault();

        if (!this.#canEdit()) {
            return;
        }
        this.#blockElement(event)?.querySelector("input[type='file']")?.click();
    }

    uploadImage(event) {
        const file = event.target.files[0];
        const index = this.#blockIndex(event);
        const block = index === null ? null : this.blocks[index];

        if (!this.#canEdit() || !file || block?.type !== "image") {
            return;
        }

        const request = {};
        this.uploads.set(block, request);
        this.#uploadStatus(block, "Uploading image…");

        return uploadFile(this.prefix("/files"), file)
            .then(data => {
                const currentIndex = this.blocks.indexOf(block);
                const src = this.#imageSrc(data.url);

                if (
                    !this.connected ||
                    currentIndex === -1 ||
                    this.uploads.get(block) !== request
                ) {
                    return;
                }

                if (!src) {
                    throw new Error(
                        "The upload response did not include a valid image URL."
                    );
                }

                this.#patchBlock(
                    currentIndex,
                    { src, name: file.name },
                    { render: true }
                );
            })
            .catch(() => {
                if (this.connected && this.uploads.get(block) === request) {
                    this.#uploadStatus(
                        block,
                        "Image upload failed. Please try again."
                    );
                }
            })
            .finally(() => {
                event.target.value = "";
            });
    }

    #uploadStatus(block, message) {
        const index = this.blocks.indexOf(block);
        const status = this.canvasTarget.querySelector?.(
            `[data-block-index="${index}"] [data-upload-status]`
        );

        if (status) {
            status.textContent = message;
        }
    }

    updateCode(event) {
        this.#patchBlock(event, { code: event.target.value });
    }

    updateCodeLanguage(event) {
        this.#patchBlock(event, { language: event.target.value.trim() });
    }

    updateEmbed(event) {
        if (!this.#canEdit()) {
            return;
        }

        const url = event.target.value.trim();
        const html = this.#embedHtml(url);

        this.#patchBlock(event, { url, html });

        const preview = this.#blockElement(event)?.querySelector(
            "[data-embed-preview='true']"
        );

        if (preview) {
            preview.innerHTML = html;
        }
    }

    paste(event) {
        if (!this.#canEdit() || !event.clipboardData) {
            return;
        }

        event.preventDefault();
        const html = event.clipboardData.getData("text/html");
        const list = event.target.closest("[data-block-type='list']");

        if (html && !list) {
            document.execCommand(
                "insertHTML",
                false,
                this.#sanitizeInlineHtml(html)
            );
        } else {
            document.execCommand(
                "insertText",
                false,
                event.clipboardData.getData("text/plain")
            );
        }
    }

    keydown(event) {
        if (!this.#canEdit()) {
            return;
        }

        const index = this.#blockIndex(event);
        const block = index === null ? null : this.blocks[index];

        if (!block) {
            return;
        }

        if (event.key === "Backspace") {
            this.#deleteEmptyBlock(event, index);
            return;
        }

        if (event.key === "Enter" && !event.shiftKey) {
            this.#insertAfterEnter(event, index, block);
        }
    }

    #render() {
        if (this.documentData === null) {
            this.canvasTarget.innerHTML =
                '<p class="text-muted" role="status">This content cannot be edited. The original value has been preserved.</p>';
            return;
        }

        this.canvasTarget.innerHTML =
            this.blocks
                .map((block, index) => this.#blockTemplate(block, index))
                .join("") || this.#addTemplate(0, "below");
    }

    #blockTemplate(block, index) {
        if (!this.#supportedBlock(block)) {
            return `<div class="block-editor-block" data-block="true" data-block-index="${index}">${this.#addTemplate(index, "above")}<p class="text-muted" role="status">Unsupported block. The original data has been preserved.</p>${this.#addTemplate(index + 1, "below")}</div>`;
        }

        block = this.#normalize(block);

        return `
            <div class="block-editor-block" data-block="true" data-block-index="${index}" data-block-type="${block.type}">
                ${this.#addTemplate(index, "above")}
                <div class="block-editor-content">
                    ${this.#headerTemplate(block)}
                    ${RICH_TEXT_BLOCKS.has(block.type) ? this.#linkEditorTemplate() : ""}
                    ${this.#bodyTemplate(block)}
                </div>
                ${this.#addTemplate(index + 1, "below")}
            </div>
        `;
    }

    #headerTemplate(block) {
        return `
            <div class="block-editor-header">
                <span class="block-editor-label">${this.#label(block)}</span>
                ${this.#hasTools() ? this.#toolsTemplate(block) : ""}
            </div>
        `;
    }

    #toolsTemplate(block) {
        return `
            <div class="block-editor-tools">
                ${RICH_TEXT_BLOCKS.has(block.type) ? this.#inlineToolbarTemplate() : ""}
                <div class="block-editor-settings">
                    ${block.type === "heading" ? this.#headingLevelTemplate(block) : ""}
                    ${block.type === "code" ? this.#codeLanguageTemplate(block) : ""}
                    ${this.#typeTemplate(block)}
                    <button type="button" class="btn btn-sm btn-link text-danger block-editor-remove" data-action="block-editor#deleteBlock" ${this.#disabledAttr()}>Delete</button>
                </div>
            </div>
        `;
    }

    #addTemplate(index, position) {
        if (!this.#hasTools()) {
            return "";
        }

        const type = this.#availableTypes().includes("paragraph")
            ? "paragraph"
            : this.#availableTypes()[0];
        const label = `Add ${BLOCKS[type].title.toLowerCase()} ${position === "above" ? "above" : "below"}`;

        return `
            <div class="block-editor-add block-editor-add-${position}">
                <button type="button"
                        class="block-editor-add-button"
                        title="${label}"
                        aria-label="${label}"
                        data-action="block-editor#insertParagraph"
                        data-insert-index="${index}"
                        ${this.#disabledAttr()}>+</button>
            </div>
        `;
    }

    #inlineToolbarTemplate() {
        return `
            <div class="block-editor-inline-toolbar" aria-label="Inline formatting">
                ${INLINE_BUTTONS.map(
                    ([command, label]) => `
                    <button type="button"
                            class="block-editor-inline-button"
                            data-action="mousedown->block-editor#formatInline"
                            data-inline-command="${command}"
                            ${this.#disabledAttr()}>
                        ${label}
                    </button>
                `
                ).join("")}
            </div>
        `;
    }

    #linkEditorTemplate() {
        return `
            <div class="block-editor-link-editor" data-link-editor="true" hidden>
                <input type="url" class="form-control form-control-sm" data-link-url="true" placeholder="https://example.com">
                <button type="button" class="btn btn-sm btn-primary" data-action="mousedown->block-editor#applyLink">Apply</button>
                <button type="button" class="btn btn-sm btn-light" data-action="mousedown->block-editor#unlink">Unlink</button>
                <button type="button" class="btn btn-sm btn-link" data-action="mousedown->block-editor#cancelLink">Cancel</button>
            </div>
        `;
    }

    #bodyTemplate(block) {
        if (block.type === "image") {
            return this.#imageTemplate(block);
        }

        if (block.type === "code") {
            return this.#codeTemplate(block);
        }

        if (block.type === "embed") {
            return this.#embedTemplate(block);
        }

        if (block.type === "list") {
            return this.#listTemplate(block);
        }

        return this.#textTemplate(block);
    }

    #textTemplate(block) {
        const tag =
            block.type === "heading" ? this.#headingTag(block.level) : "p";
        const html = this.#sanitizeInlineHtml(
            block.html ?? this.#textToHtml(block.text ?? "")
        );

        return `
            <div class="block-editor-rich-text">
                <${tag}
                    class="block-editor-body block-editor-${block.type}"
                    data-block-content="true"
                    data-placeholder="${this.#escapeAttr(this.#placeholder(block.type))}"
                    data-action="input->block-editor#updateText keydown->block-editor#keydown paste->block-editor#paste"
                    contenteditable="${!this.#isLocked()}"
                    spellcheck="true">${html}</${tag}>
            </div>
        `;
    }

    #listTemplate(block) {
        const placeholder = this.#escapeAttr(this.#placeholder("list"));
        const items = this.#compactListItems(block.items)
            .map((item, index) => {
                const attribute =
                    index === 0 ? ` data-placeholder="${placeholder}"` : "";

                return `<li${attribute}>${this.#escape(item)}</li>`;
            })
            .join("");

        return `<ul class="block-editor-body block-editor-list" data-block-content="true" data-placeholder="${placeholder}" data-action="input->block-editor#updateList keydown->block-editor#keydown paste->block-editor#paste" contenteditable="${!this.#isLocked()}">${items}</ul>`;
    }

    #imageTemplate(block) {
        return `
            <div class="block-editor-image">
                ${this.#imageSrc(block.src) ? `<img src="${this.#escapeAttr(this.#imageSrc(block.src))}" alt="${this.#escapeAttr(block.alt ?? "")}">` : ""}
                <div class="block-editor-image-actions">
                    <button type="button" class="btn btn-sm btn-light" data-action="block-editor#chooseImage" ${this.#disabledAttr()}>
                        ${block.src ? "Replace image" : "Upload image"}
                    </button>
                    <span class="block-editor-image-name">${this.#escape(block.name || block.src || this.#placeholder("image"))}</span>
                    <span class="small text-muted" data-upload-status role="status" aria-live="polite"></span>
                    <input type="file" accept="image/*" class="d-none" data-action="change->block-editor#uploadImage" ${this.#disabledAttr()}>
                </div>
            </div>
        `;
    }

    #codeTemplate(block) {
        return `
            <div class="block-editor-code">
                <textarea class="form-control block-editor-code-input"
                          rows="6"
                          placeholder="${this.#escapeAttr(this.#placeholder("code"))}"
                          data-action="input->block-editor#updateCode"
                          ${this.#readonlyAttr()}
                          ${this.#disabledAttr()}>${this.#escape(block.code ?? "")}</textarea>
            </div>
        `;
    }

    #embedTemplate(block) {
        return `
            <div class="block-editor-embed">
                <input type="url"
                       class="form-control form-control-sm block-editor-embed-input"
                       placeholder="${this.#escapeAttr(this.#placeholder("embed"))}"
                       value="${this.#escapeAttr(block.url ?? "")}"
                       data-action="input->block-editor#updateEmbed"
                       ${this.#readonlyAttr()}
                       ${this.#disabledAttr()}>
                <div class="block-editor-embed-preview" data-embed-preview="true">${block.html || ""}</div>
            </div>
        `;
    }

    #typeTemplate(block) {
        const types = this.#availableTypes();

        if (types.length === 0) {
            return "";
        }

        if (!types.includes(block.type)) {
            types.push(block.type);
        }

        return `
            <select class="form-select form-select-sm block-editor-type"
                    data-action="change->block-editor#changeType"
                    ${this.#disabledAttr()}>
                ${types
                    .map(
                        type => `
                    <option value="${type}" ${type === block.type ? "selected" : ""}>
                        ${this.#escape(BLOCKS[type]?.title ?? type)}
                    </option>
                `
                    )
                    .join("")}
            </select>
        `;
    }

    #headingLevelTemplate(block) {
        return `
            <select class="form-select form-select-sm block-editor-heading-level"
                    data-action="change->block-editor#changeHeadingLevel"
                    ${this.#disabledAttr()}>
                ${HEADING_LEVELS.map(
                    level => `
                    <option value="${level}" ${level === this.#headingLevel(block.level) ? "selected" : ""}>
                        H${level}
                    </option>
                `
                ).join("")}
            </select>
        `;
    }

    #codeLanguageTemplate(block) {
        return `
            <input type="text"
                   class="form-control form-control-sm block-editor-code-language"
                   placeholder="Language"
                   value="${this.#escapeAttr(block.language ?? "")}"
                   data-action="input->block-editor#updateCodeLanguage"
                   ${this.#readonlyAttr()}
                   ${this.#disabledAttr()}>
        `;
    }

    #insertAt(index, block) {
        const insertAt = Math.min(this.blocks.length, Math.max(0, index));

        this.blocks.splice(insertAt, 0, this.#normalize(block));
        this.#commitAndFocus(insertAt);
    }

    #insertAfter(index, block) {
        const insertAt = Math.min(this.blocks.length, Math.max(0, index) + 1);

        this.blocks.splice(insertAt, 0, this.#normalize(block));
        this.#commitAndFocus(insertAt);
    }

    #deleteAt(index) {
        this.blocks.splice(index, 1);

        if (this.blocks.length === 0) {
            this.blocks = [{ ...DEFAULT_BLOCK }];
        }

        this.#commitAndFocus(Math.max(0, index - 1));
    }

    #replaceBlock(source, transform) {
        this.#withBlock(source, (block, index) => {
            const nextBlock = transform(block, index);

            if (!nextBlock) {
                return;
            }

            this.blocks[index] = { ...block, ...this.#normalize(nextBlock) };
            this.#commit();
        });
    }

    #patchBlock(source, patch, options = {}) {
        if (!this.#canEdit()) {
            return;
        }

        this.#withBlock(source, (block, index) => {
            const attributes =
                typeof patch === "function" ? patch(block, index) : patch;

            if (!attributes) {
                return;
            }

            Object.assign(block, attributes);
            options.render ? this.#commit() : this.#sync();
        });
    }

    #withBlock(source, callback) {
        const index = this.#blockIndex(source);
        const block = index === null ? null : this.blocks[index];

        return this.#supportedBlock(block) ? callback(block, index) : null;
    }

    #commit() {
        this.#sync();
        this.#render();
    }

    #commitAndFocus(index) {
        this.#commit();
        this.#focusWhenReady(index);
    }

    #sync() {
        this.textareaTarget.value = JSON.stringify({
            ...this.documentData,
            blocks: this.blocks,
        });
        this.textareaTarget.dispatchEvent(
            new Event("change", { bubbles: true })
        );
    }

    #parseBlocks(value) {
        try {
            const parsed = JSON.parse(value || '{"blocks":[]}');

            if (
                parsed &&
                typeof parsed === "object" &&
                !Array.isArray(parsed) &&
                Array.isArray(parsed.blocks)
            ) {
                this.documentData = parsed;
                return parsed.blocks.length
                    ? parsed.blocks
                    : [{ ...DEFAULT_BLOCK }];
            }
        } catch {
            // Keep malformed source intact rather than replacing it with an empty document.
        }

        return [];
    }

    #supportedBlock(block) {
        if (
            !block ||
            typeof block !== "object" ||
            Array.isArray(block) ||
            typeof block.type !== "string" ||
            !Object.hasOwn(BLOCKS, block.type)
        ) {
            return false;
        }

        const strings = {
            paragraph: ["text", "html"],
            heading: ["text", "html", "tag"],
            quote: ["text", "html"],
            image: ["src", "alt", "name"],
            code: ["code", "language"],
            embed: ["url", "html"],
            list: [],
        }[block.type];

        return (
            strings.every(
                key =>
                    block[key] === undefined || typeof block[key] === "string"
            ) &&
            (block.type !== "heading" ||
                block.level === undefined ||
                ["number", "string"].includes(typeof block.level)) &&
            (block.type !== "list" ||
                block.items === undefined ||
                (Array.isArray(block.items) &&
                    block.items.every(item => typeof item === "string")))
        );
    }

    #normalize(block) {
        if (!block || typeof block !== "object") {
            return { ...DEFAULT_BLOCK };
        }

        if (block.type === "image") {
            return {
                type: "image",
                src: String(block.src ?? ""),
                alt: String(block.alt ?? ""),
                name: String(block.name ?? ""),
            };
        }

        if (block.type === "code") {
            return {
                type: "code",
                language: String(block.language ?? ""),
                code: String(block.code ?? ""),
            };
        }

        if (block.type === "embed") {
            const url = String(block.url ?? "");

            return { type: "embed", url, html: this.#embedHtml(url) };
        }

        if (block.type === "list") {
            const items = Array.isArray(block.items) ? block.items : [""];

            return { type: "list", items: this.#compactListItems(items) };
        }

        const text = String(block.text ?? "");
        const html = this.#sanitizeInlineHtml(
            block.html ?? this.#textToHtml(text)
        );

        if (block.type === "heading") {
            return {
                type: "heading",
                level: this.#headingLevel(block.level, block.tag),
                text,
                html,
            };
        }

        if (block.type === "quote") {
            return { type: "quote", text, html };
        }

        return { type: "paragraph", text, html };
    }

    #newBlock(type, attributes = {}) {
        const base = {
            heading: { type: "heading", level: 2, text: "", html: "" },
            quote: { type: "quote", text: "", html: "" },
            list: { type: "list", items: [""] },
            image: { type: "image", src: "", alt: "", name: "" },
            code: { type: "code", language: "", code: "" },
            embed: { type: "embed", url: "", html: "" },
            paragraph: { ...DEFAULT_BLOCK },
        }[type] ?? { ...DEFAULT_BLOCK };

        return { ...base, ...attributes };
    }

    #convertBlock(block, type) {
        const text = this.#blockText(block);
        const html = ["paragraph", "heading", "quote"].includes(block.type)
            ? (block.html ?? this.#textToHtml(text))
            : this.#textToHtml(text);

        if (type === "list") {
            return {
                type: "list",
                items:
                    block.type === "list"
                        ? block.items
                        : text.split("\n").filter(item => item.trim() !== ""),
            };
        }

        if (type === "image") {
            return this.#newBlock("image", {
                src: block.type === "image" ? block.src : "",
                alt: text,
            });
        }

        if (type === "code") {
            return this.#newBlock("code", {
                code: block.type === "code" ? block.code : text,
                language: block.type === "code" ? block.language : "",
            });
        }

        if (type === "embed") {
            return this.#newBlock("embed", {
                url: block.type === "embed" ? block.url : "",
            });
        }

        return this.#newBlock(type, { text, html });
    }

    #blockText(block) {
        if (block.type === "list") {
            return (block.items ?? []).join("\n");
        }

        if (block.type === "code") {
            return block.code ?? "";
        }

        return block.text ?? block.alt ?? block.url ?? "";
    }

    #deleteEmptyBlock(event, index) {
        const content = this.#contentFromEvent(event);

        if (this.#isEmpty(content) && this.#isSelectionAtStart(content)) {
            event.preventDefault();
            this.#deleteAt(index);
        }
    }

    #insertAfterEnter(event, index, block) {
        if (block.type === "list" && !this.#isEmpty(event.target)) {
            return;
        }

        event.preventDefault();
        this.#insertAfter(index, this.#newBlock("paragraph"));
    }

    #blockIndex(source) {
        if (Number.isInteger(source)) {
            return source >= 0 && source < this.blocks.length ? source : null;
        }

        return this.#indexFromEvent(source);
    }

    #indexFromEvent(event) {
        const index = Number(this.#blockElement(event)?.dataset.blockIndex);

        return Number.isInteger(index) &&
            index >= 0 &&
            index < this.blocks.length
            ? index
            : null;
    }

    #blockElement(event) {
        return event?.target?.closest("[data-block='true']");
    }

    #contentFromEvent(event) {
        return event.target.closest("[data-block-content='true']");
    }

    #insertIndexFromEvent(event) {
        const index = Number(event.currentTarget.dataset.insertIndex);

        return Number.isInteger(index) ? index : this.blocks.length;
    }

    #focus(index) {
        const field = this.canvasTarget.querySelector(
            `[data-block-index="${index}"] [data-block-content="true"], ` +
                `[data-block-index="${index}"] textarea, ` +
                `[data-block-index="${index}"] input[type="url"]`
        );

        if (!field) {
            return false;
        }

        field.focus({ preventScroll: true });

        if (field.matches("[contenteditable='true']")) {
            this.#placeCaretAtEnd(field);
        }

        return document.activeElement === field;
    }

    #focusWhenReady(index) {
        requestAnimationFrame(() => {
            if (this.connected) {
                this.#focus(index);
            }
        });
    }

    #placeCaretAtEnd(element) {
        const range = document.createRange();
        const selection = window.getSelection();

        range.selectNodeContents(element);
        range.collapse(false);
        selection?.removeAllRanges();
        selection?.addRange(range);
    }

    #focusedEditable() {
        return document.activeElement?.matches("[data-block-content='true']")
            ? document.activeElement
            : null;
    }

    #openLinkEditor(editable) {
        const selection = window.getSelection();

        if (
            !selection ||
            selection.rangeCount === 0 ||
            !editable.contains(selection.anchorNode)
        ) {
            return;
        }

        const range = selection.getRangeAt(0);
        const anchor =
            selection.anchorNode?.parentElement?.closest("a") ??
            range.commonAncestorContainer.parentElement?.closest("a");
        const editor = editable
            .closest(".block-editor-content")
            ?.querySelector("[data-link-editor='true']");
        const input = editor?.querySelector("[data-link-url='true']");

        if (!editor || !input) {
            return;
        }

        this.#closeLinkEditor();
        this.pendingLinkRange = range.cloneRange();
        this.pendingLinkAnchor = editable.contains(anchor) ? anchor : null;
        input.value = this.pendingLinkAnchor?.getAttribute("href") ?? "";
        editor.hidden = false;
        input.focus();
        input.select();
    }

    #closeLinkEditor() {
        this.canvasTarget
            .querySelectorAll("[data-link-editor='true']")
            .forEach(editor => {
                editor.hidden = true;
            });

        this.pendingLinkRange = null;
        this.pendingLinkAnchor = null;
    }

    #writeLink(url) {
        const anchor = this.pendingLinkAnchor ?? document.createElement("a");
        anchor.href = url;
        anchor.rel = "noopener noreferrer";
        anchor.target = "_blank";

        if (this.pendingLinkRange && !this.pendingLinkAnchor) {
            anchor.textContent = this.pendingLinkRange.collapsed
                ? url
                : this.pendingLinkRange.toString();
            this.pendingLinkRange.deleteContents();
            this.pendingLinkRange.insertNode(anchor);
        }
    }

    #linkEditorFromEvent(event) {
        return event.currentTarget.closest("[data-link-editor='true']");
    }

    #editableForLinkEditor(editor) {
        return editor
            ?.closest(".block-editor-content")
            ?.querySelector("[data-block-content='true']");
    }

    #sanitizeInlineHtml(html) {
        const template = document.createElement("template");
        template.innerHTML = String(html ?? "");
        this.#sanitizeNode(template.content);

        return template.innerHTML;
    }

    #sanitizeNode(parent) {
        Array.from(parent.childNodes).forEach(node => {
            if (node.nodeType === Node.TEXT_NODE) {
                return;
            }

            if (node.nodeType !== Node.ELEMENT_NODE) {
                node.remove();
                return;
            }

            const element = node;

            if (!INLINE_TAGS.has(element.tagName)) {
                this.#sanitizeNode(element);
                element.replaceWith(...Array.from(element.childNodes));
                return;
            }

            this.#sanitizeAttributes(element);
            this.#sanitizeNode(element);
        });
    }

    #sanitizeAttributes(element) {
        Array.from(element.attributes).forEach(attribute => {
            if (element.tagName === "A" && attribute.name === "href") {
                const href = this.#safeHref(attribute.value);
                href === null
                    ? element.removeAttribute("href")
                    : element.setAttribute("href", href);
                return;
            }

            element.removeAttribute(attribute.name);
        });

        if (element.tagName === "A") {
            element.setAttribute("rel", "noopener noreferrer");
            element.setAttribute("target", "_blank");
        }
    }

    #embedHtml(url) {
        const src = this.#embedSrc(url);

        if (src === null) {
            return "";
        }

        return `
            <iframe
                src="${this.#escapeAttr(src)}"
                loading="lazy"
                title="Embedded video"
                referrerpolicy="strict-origin-when-cross-origin"
                sandbox="allow-scripts allow-same-origin allow-presentation"
                allowfullscreen
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share">
            </iframe>
        `;
    }

    #embedSrc(url) {
        try {
            const parsed = new URL(this.#linkUrl(url));
            const host = parsed.hostname.replace(/^www\./, "");

            if (
                !["https:", "http:"].includes(parsed.protocol) ||
                parsed.username ||
                parsed.password
            ) {
                return null;
            }

            if (["youtu.be", "youtube.com", "m.youtube.com"].includes(host)) {
                const id =
                    host === "youtu.be"
                        ? parsed.pathname.slice(1)
                        : parsed.pathname === "/watch"
                          ? parsed.searchParams.get("v")
                          : /^\/(embed|shorts)\//.test(parsed.pathname)
                            ? parsed.pathname.split("/")[2]
                            : null;

                return /^[a-zA-Z0-9_-]{11}$/.test(id ?? "")
                    ? `https://www.youtube.com/embed/${id}`
                    : null;
            }

            if (host === "vimeo.com") {
                const id = parsed.pathname.split("/").filter(Boolean)[0];
                return /^\d+$/.test(id ?? "")
                    ? `https://player.vimeo.com/video/${id}`
                    : null;
            }
        } catch {
            return null;
        }

        return null;
    }

    #linkUrl(value) {
        const url = String(value ?? "").trim();

        if (!url || /[\u0000-\u0020\u007f]/.test(url)) {
            return null;
        }

        if (/^[a-z][a-z\d+.-]*:/i.test(url)) {
            return this.#safeHref(url);
        }

        return this.#safeHref(/^[/#]/.test(url) ? url : `https://${url}`);
    }

    #safeHref(value) {
        const href = String(value ?? "").trim();

        if (/[\u0000-\u0020\u007f]/.test(href) || href.includes("\\")) {
            return null;
        }

        return href === "" ||
            /^(https?:\/\/|mailto:|tel:|\/(?!\/)|#)/i.test(href)
            ? href
            : null;
    }

    #imageSrc(value) {
        const src = this.#safeHref(value);
        return src && /^(https?:\/\/|\/)/i.test(src) ? src : null;
    }

    #availableTypes() {
        const types = (this.toolsValue ?? [])
            .map(tool => tool?.type)
            .filter(type => Object.hasOwn(BLOCKS, type));

        return types.length > 0 || this.hasToolsValue
            ? types
            : Object.keys(BLOCKS);
    }

    #hasTools() {
        return this.#canEdit() && this.#availableTypes().length > 0;
    }

    #label(block) {
        return block.type === "heading"
            ? `H${this.#headingLevel(block.level)}`
            : (BLOCKS[block.type]?.shortcut ?? block.type);
    }

    #placeholder(type) {
        return PLACEHOLDERS[type] ?? "Write something useful";
    }

    #compactListItems(items) {
        const compacted = items.map(item => String(item ?? "").trim());

        while (compacted.length > 1 && compacted.at(-1) === "") {
            compacted.pop();
        }

        return compacted.length > 0 ? compacted : [""];
    }

    #headingLevel(level, tag) {
        const parsed = Number(level ?? String(tag ?? "").replace("h", ""));

        return Number.isInteger(parsed) && parsed >= 1 && parsed <= 6
            ? parsed
            : 2;
    }

    #headingTag(level) {
        return `h${this.#headingLevel(level)}`;
    }

    #isEmpty(element) {
        return (element?.textContent ?? "").replace(/\s+/g, "").length === 0;
    }

    #isSelectionAtStart(element) {
        const selection = window.getSelection();

        if (!selection || selection.rangeCount === 0 || !element) {
            return false;
        }

        const range = selection.getRangeAt(0);

        if (!range.collapsed || !element.contains(range.startContainer)) {
            return false;
        }

        const probe = range.cloneRange();
        probe.selectNodeContents(element);
        probe.setEnd(range.startContainer, range.startOffset);

        return probe.toString().length === 0;
    }

    #canEdit() {
        return this.documentData !== null && !this.#isLocked();
    }

    #isLocked() {
        return this.readonlyValue || this.disabledValue;
    }

    #disabledAttr() {
        return this.#isLocked() ? "disabled" : "";
    }

    #readonlyAttr() {
        return this.readonlyValue ? "readonly" : "";
    }

    #textToHtml(text) {
        return this.#escape(text).replace(/\n/g, "<br>");
    }

    #syncEditable(editable) {
        editable.dispatchEvent(new Event("input", { bubbles: true }));
    }

    #escape(value) {
        const element = document.createElement("div");
        element.textContent = String(value ?? "");

        return element.innerHTML;
    }

    #escapeAttr(value) {
        return this.#escape(value).replace(/"/g, "&quot;");
    }
}
