import ApplicationController from "./application_controller";
import {Popover} from 'bootstrap';

export default class extends ApplicationController {
    /**
     *
     */
    connect() {
        this.popover = new Popover(
            this.element
        );
    }

    /**
     *
     * @param event
     */
    trigger(event) {
        event.preventDefault();
        this.popover.toggle();
    }
}
