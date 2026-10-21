import ApplicationController from "./application_controller";
import Sortable from "sortablejs";
import { uploadFile } from "../helpers/upload";

export default class extends ApplicationController {
    static values = {
        name: {
            type: String,
            default: "attachment[]",
        },
        attachment: {
            type: Array,
            default: [],
        },
        group: {
            type: String,
            default: "",
        },
        storage: {
            type: String,
            default: "public",
        },
        path: {
            type: String,
            default: "",
        },
        count: {
            type: Number,
            default: 0,
        },
        size: {
            type: Number,
            default: 0,
        },
        loading: {
            type: Number,
            default: 0,
        },
        uploadUrl: {
            type: String,
        },
        sortUrl: {
            type: String,
        },
        errorSize: {
            type: String,
            default: 'File ":name" is too large to upload',
        },
        errorType: {
            type: String,
            default: "The attached file must be an image",
        },
    };

    static targets = ["files", "preview", "container", "template", "nullable"];

    connect() {
        const dropzone = this.element.querySelector(".sortable-dropzone");
        if (this.previewElement !== dropzone) {
            this.attachmentValue.forEach(attachment => this.renderPreview(attachment));
            this.previewElement = dropzone;
        }
        this.togglePlaceholderShow();

        if (this.sortable) return;
        this.sortable = new Sortable(dropzone, {
            disabled: this.locked,
            filter: ".attach-file-uploader",
            draggable: ".pip",
            animation: 150,
            onEnd: () => {
                this.reorderElements();
            },
        });
    }

    disconnect() {
        this.sortable?.destroy();
        this.sortable = null;
    }

    prepareClone(element) {
        element.setAttribute("data-attach-attachment-value", JSON.stringify(this.orderedAttachments()));
        element.querySelector('[data-attach-target="nullable"]').value = "0";
    }

    get locked() {
        return this.filesTarget.closest("fieldset:disabled") !== null ||
            this.filesTarget.hasAttribute("readonly");
    }

    orderedAttachments() {
        const attachments = new Map(this.attachmentValue.map(attachment => [String(attachment.id), attachment]));
        return Array.from(this.element.querySelectorAll(".pip input"), input => attachments.get(String(input.value)))
            .filter(Boolean);
    }

    preventDefaults(event) {
        event.preventDefault();
        event.stopPropagation();
    }

    dropFiles(event) {
        if (this.locked) return;
        this.filesTarget.files = event.dataTransfer.files;

        this.filesTarget.dispatchEvent(new Event("change", { bubbles: true }));
    }

    selectFiles(event) {
        if (this.locked) return;
        [...event.target.files].forEach(file => {
            let sizeMB = file.size / 1000 / 1000; //MB (Not MiB)

            if (this.sizeValue > 0 && sizeMB > this.sizeValue) {
                this.toast(this.errorSizeValue.replace(":name", file.name));
                //alert(this.errorSizeValue.replace(':name', file.name));
                return;
            }

            this.upload(file);
        });

        // clear
        let data = new DataTransfer();
        event.target.files = data.files;
    }

    upload(file) {
        if (this.locked) return;
        this.loadingValue = this.loadingValue + 1;
        this.element.ariaBusy = "true";

        uploadFile(this.uploadUrlValue, file, {
            data: {
                storage: this.storageValue,
                group: this.groupValue,
                path: this.pathValue,
                sort: this.countValue + 1,
            },
        })
            .then(attachment => {
                this.element.ariaBusy = "false";
                this.loadingValue = this.loadingValue - 1;

                let limit = this.attachmentValue.length < this.countValue;

                if (!limit && this.countValue > 0) {
                    return;
                }

                this.attachmentValue = [...this.attachmentValue, attachment];

                // Update Label after push
                this.togglePlaceholderShow();
                this.renderPreview(attachment);
            })
            .catch(error => {
                this.element.ariaBusy = "false";
                this.loadingValue = this.loadingValue - 1;
                this.togglePlaceholderShow();
                console.error("Error:", error);

                this.toast(
                    error.response?.data?.message ?? this.errorTypeValue
                );
            });
    }

    remove(event) {
        if (this.locked) return;
        const i = event.currentTarget.getAttribute("data-index");

        event.currentTarget.closest(".pip").remove();

        this.attachmentValue = this.attachmentValue.filter(
            file => String(file.id) !== String(i)
        );

        this.togglePlaceholderShow();
    }

    /**
     *
     */
    togglePlaceholderShow() {
        let toggle =
            this.attachmentValue.length >= this.countValue &&
            this.countValue !== 0;

        this.containerTarget.classList.toggle("d-none", toggle);
        this.filesTarget.disabled = toggle;

        // Disable the nullable field if there is at least one valid value and the count equals 1.
        // If there are no values or if there are multiple values, the field will remain enabled and be sent to the server as `null`.
        if (this.countValue === 1) {
            this.nullableTarget.disabled = this.attachmentValue.length > 0;
        } else {
            // Unfortunately, this does not work with multiple selections because the server receives [0 => null] instead of an empty array.
            // Therefore, this logic applies only to single selections.
            this.nullableTarget.disabled = true;
        }
    }

    /**
     * @param attachment
     * @param replace
     */
    renderPreview(attachment, replace = null) {
        let preview = this.templateTarget.content
            .querySelector("*")
            .cloneNode(true);

        const values = {
            id: attachment.id,
            url: attachment.url,
            original_name: attachment.original_name,
            mime: attachment.mime,
            name: this.nameValue,
        };

        [preview, ...preview.querySelectorAll("*")].forEach(element => {
            [...element.attributes].forEach(attribute => {
                element.setAttribute(attribute.name, attribute.value.replace(
                    /{(id|url|original_name|mime|name)}/gi,
                    (placeholder, key) => values[key.toLowerCase()]
                ));
            });
        });

        if (replace !== null) {
            this.element.querySelector(`#attachment-${replace}`).replaceWith(preview);
            return;
        }

        this.containerTarget.insertAdjacentElement("beforebegin", preview);
    }

    reorderElements() {
        if (this.locked) return;
        this.attachmentValue = this.orderedAttachments();
        const items = {};
        let elements = this.element.querySelectorAll(`:scope .pip`);

        elements.forEach((preview, index) => {
            const id = preview.querySelector("input").value;
            items[id] = index;
        });

        fetch(this.sortUrlValue, {
            method: "POST",
            body: JSON.stringify({
                files: items,
            }),
            headers: {
                "Content-Type": "application/json;charset=utf-8",
                "X-CSRF-Token": document.head.querySelector(
                    'meta[name="csrf_token"]'
                ).content,
            },
        }).then();
    }
}
