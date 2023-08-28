import { Controller } from '@hotwired/stimulus';
import ApplicationController from "./application_controller";

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

    static targets = ['files', 'preview', 'container'];

    connect() {
        this.attachmentValue.forEach((id) => this.renderPreview(id));
        this.togglePlaceholderShow();
    }

    change(event) {
        [...event.target.files].forEach((file) => {
            let sizeMB = file.size / 1000 / 1000; //MB (Not MiB)

            if (sizeMB > this.sizeValue) {
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
     *
     * @param attachment
     * @param replace
     */
    renderPreview(attachment, replace = null) {
        const pip = document.createElement('div');
        pip.id = `attachment-${attachment.id}`;
        pip.classList.add('pip', 'col', 'position-relative');

        pip.innerHTML = `
          <input type="hidden" name="${this.nameValue}" value="${attachment.id}">
          <img class="attach-image rounded border user-select-none" src="${attachment.url}"/>
          <button class="btn-close border shadow position-absolute end-0 top-0" type="button" data-action="click->attach#remove" data-index="${attachment.id}"></button>
      `;

        if (replace !== null) {
            this.element.querySelector(`#attachment-${replace}`).outerHTML = pip.outerHTML;
            return;
        }

        this.containerTarget.insertAdjacentElement('beforebegin', pip);
    }
}
