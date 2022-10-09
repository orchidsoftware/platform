import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    /**
     *
     */
    connect() {
        const checkbox = this.element.querySelector('input:not([hidden])');

        if (checkbox) {
            checkbox.indeterminate = this.data.get('indeterminate')
        }
    }
}
