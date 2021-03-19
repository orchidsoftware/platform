import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    /**
     *
     * @param event
     * @returns {boolean}
     */
    confirm(event) {
        let button = this.element.outerHTML
            .replace('btn-link', 'btn-default')
            .replace(/data-action="(.*?)"/g, '');

        this.application
            .getControllerForElementAndIdentifier(this.confirmModal, 'confirm')
            .open({
                'message': this.data.get('confirm'),
                'button': button,
            });

        event.preventDefault();
        return false;
    }


    /**
     *
     * @returns {HTMLElement}
     */
    get confirmModal() {
        return document.getElementById(`confirm-dialog`);
    }
}
