import { Controller } from 'stimulus';

export default class extends Controller {

    /**
     *
     * @param event
     * @returns {*}
     */
    targetModal(event) {
        const target = event.target,
            parentTarget = event.target.parentElement,
            key = target.dataset.modalKey || parentTarget.dataset.modalKey;

        this.application.getControllerForElementAndIdentifier(
            document.getElementById(`screen-modal-${key}`),
            'screen--modal',
        ).open({
            title: target.dataset.modalTitle || parentTarget.dataset.modalTitle,
            submit: target.dataset.modalAction || parentTarget.dataset.modalAction,
            params: target.dataset.modalParams || parentTarget.dataset.modalParams || '[]',
        });

        return event.preventDefault();
    }
}
