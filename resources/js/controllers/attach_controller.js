import ApplicationController from "./application_controller";
import Sortable from 'sortablejs';

export default class extends ApplicationController {
    static values = {
        name: {
            type: String,
            default: 'attachment[]',
        },
        attachment: {
            type: Array,
            default: [],
        },
        group: {
            type: String,
        },
        storage: {
            type: String,
            default: 'public',
        },
        path: {
            type: String,
        },
        count: {
            type: Number,
            default: 3,
        },
        size: {
            type: Number,
            default: 10,
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
            default: 'The attached file must be an image',
        },
    };

    static targets = ['files', 'preview', 'container', 'template', 'nullable'];

    connect() {
        this.attachmentValue.forEach((id) => this.renderPreview(id));
        this.togglePlaceholderShow();

        new Sortable(this.element.querySelector('.sortable-dropzone'), {
            disabled: this.filesTarget.disabled === true || this.filesTarget.readonly === true,
            filter: ".attach-file-uploader",
            draggable:'.pip',
            animation: 150,
            onEnd: () => {
                this.reorderElements();
            },
        });
    }


    preventDefaults (event) {
        event.preventDefault()
        event.stopPropagation()
    }

    dropFiles(event) {
        this.filesTarget.files = event.dataTransfer.files;

        this.filesTarget.dispatchEvent(
            new Event('change', { bubbles: true })
        );
    }

    selectFiles(event) {
        [...event.target.files].forEach((file) => {
            let sizeMB = file.size / 1000 / 1000; //MB (Not MiB)

            if (sizeMB > this.sizeValue) {
                this.toast(this.errorSizeValue.replace(':name', file.name));
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
        let data = new FormData();
        data.append('file', file);
        data.append('storage', this.storageValue);
        data.append('group', this.groupValue);
        data.append('path', this.pathValue);

        this.loadingValue = this.loadingValue + 1;
        this.element.ariaBusy = 'true';

        fetch(this.uploadUrlValue, {
            method: 'POST',
            body: data,
            headers: {
                'X-CSRF-Token': document.head.querySelector('meta[name="csrf_token"]').content,
            },
        })
            .then((response) => response.json())
            .then((attachment) => {
                this.element.ariaBusy = 'false';
                this.loadingValue = this.loadingValue - 1;

                let limit = this.attachmentValue.length < this.countValue;

                if (!limit) {
                    return;
                }

                this.attachmentValue = [...this.attachmentValue, attachment];

                // Update Label after push
                this.togglePlaceholderShow();
                this.renderPreview(attachment);
            })
            .catch((error) => {
                this.element.ariaBusy = 'false';
                this.loadingValue = this.loadingValue - 1;
                this.togglePlaceholderShow();
                console.error('Error:', error);

                this.toast(this.errorTypeValue);
                //alert(this.errorTypeValue);
            });
    }

    remove(event) {
        const i = event.currentTarget.getAttribute('data-index');

        event.currentTarget.closest('.pip').remove();

        this.attachmentValue = this.attachmentValue.filter((file) => String(file.id) !== String(i));

        this.togglePlaceholderShow();
    }

    /**
     *
     */
    togglePlaceholderShow() {
        this.containerTarget.classList.toggle('d-none', this.attachmentValue.length >= this.countValue);
        this.filesTarget.disabled = this.attachmentValue.length >= this.countValue;


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
        let preview =  this.templateTarget.content.querySelector('*').cloneNode(true);

        preview.querySelectorAll('*').forEach(element => {
            preview.innerHTML = preview.innerHTML
                .replace(/{id}/gi, attachment.id)
                .replace(/{url}/gi, attachment.url)
                .replace(/{original_name}/gi, attachment.original_name)
                .replace(/{mime}/gi, attachment.mime)
                .replace(/{name}/gi, this.nameValue);
        });

        if (replace !== null) {
            this.element.querySelector(`#attachment-${replace}`).outerHTML = pip.outerHTML;
            return;
        }

        this.containerTarget.insertAdjacentElement('beforebegin', preview);
    }

    reorderElements(){
        const items = {};
        let elements = this.element.querySelectorAll(`:scope .pip`);

        elements.forEach((preview, index) => {
            const id = preview.querySelector('input').value;
            items[id] = index;
        });

        fetch(this.sortUrlValue, {
            method: 'POST',
            body: JSON.stringify({
                files: items,
            }),
            headers: {
                'X-CSRF-Token': document.head.querySelector('meta[name="csrf_token"]').content,
            },
        }).then();
    }
}
