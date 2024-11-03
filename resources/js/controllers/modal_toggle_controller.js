import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    static values = {
        title: {
            type: String,
            default: null,
        },
        key: {
            type: String,
        },
        action: {
            type: String,
        },
        parameters: {
            type: Object,
        },
        open: {
            type: Boolean,
            default: false,
        },
    }

    /**
     *
     */
    connect() {
        setTimeout(() => {
            if (!this.openValue) {
                return;
            }

            this.modal.classList.remove('fade', 'in');
            this.targetModal();
        });
    }

    /**
     *
     * @returns {*}
     */
    targetModal(event) {
        this.application
            .getControllerForElementAndIdentifier(this.modal, 'modal')
            .open({
                title: this.titleValue || this.modal.dataset.modalTitle,
                submit: this.actionValue,
                params: this.parametersValue,
            });

        if (event) {
            return event.preventDefault();
        }
    }

    /**
     *
     * @returns {HTMLElement}
     */
    get modal() {

        let modal = document.getElementById(`screen-modal-${this.keyValue}`);

        if (modal === null) {
            this.toast('The modal element does not exist.', 'warning');
        }

        return modal;
    }
}
