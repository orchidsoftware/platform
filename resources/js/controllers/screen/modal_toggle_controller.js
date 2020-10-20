import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     *
     */
    connect() {
        setTimeout(() => {
            if (!this.data.get('open')) {
                return;
            }
            this.modal.classList.remove('fade', 'in');
            this.targetModal();
        })
    }

    /**
     *
     * @returns {*}
     */
    targetModal(event) {
        this.application.getControllerForElementAndIdentifier(this.modal, 'screen--modal')
            .open({
                title: this.data.get('title') || this.modal.dataset.modalTitle,
                submit: this.data.get('action'),
                params: this.data.get('params', '[]'),
            });

        if(event) {
            return event.preventDefault();
        }
    }

    /**
     *
     * @returns {HTMLElement}
     */
    get modal() {
        return document.getElementById(`screen-modal-${this.data.get('key')}`);
    }
}
