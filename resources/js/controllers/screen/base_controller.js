import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     *
     * @param event
     * @returns {*}
     */
    targetModal(event) {
        const key = event.target.dataset.modalKey;

        this.application.getControllerForElementAndIdentifier(
            document.getElementById(`screen-modal-${key}`),
            'screen--modal',
        ).open({
            title: event.target.dataset.modalTitle,
            submit: event.target.dataset.modalAction,
            params: event.target.dataset.modalParams || '[]',
        });

        return event.preventDefault();
    }
}
