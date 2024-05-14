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
            default: null,
        },
        storage: {
            type: String,
            default: 'public',
        },
        path: {
            type: String,
            default: null,
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
        errorSize: {
            type: String,
            default: 'File ":name" is too large to upload',
        },
        errorType: {
            type: String,
            default: 'The attached file must be an image',
        },
    };

    static targets = ['files', 'preview', 'container', 'template'];

    connect() {
        this.attachmentValue.forEach((id) => this.renderPreview(id));
        this.togglePlaceholderShow();

        new Sortable(this.element.querySelector('.sortable-dropzone'), {
            animation: 150,
            onEnd: () => {
                this.reorderElements();
                this.toast('save?');
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
                alert(this.errorSizeValue.replace(':name', file.name));
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

        fetch(this.prefix('/systems/files'), {
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
                alert(this.errorTypeValue);
            });
    }

    remove(event) {
        const i = event.currentTarget.getAttribute('data-index');
        event.currentTarget.closest('.pip').remove();

        this.attachmentValue = this.attachmentValue.filter((id) => String(id) !== String(i));

        this.togglePlaceholderShow();
    }

    /**
     *
     */
    togglePlaceholderShow() {
        this.containerTarget.classList.toggle('d-none', this.attachmentValue.length >= this.countValue);
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

        fetch(this.prefix('/systems/files'), {
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
