import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    /**
     *
     */
    connect() {
        this.element
            .querySelector('input:not([hidden])')
            .indeterminate = this.data.get('indeterminate');
    }
}
