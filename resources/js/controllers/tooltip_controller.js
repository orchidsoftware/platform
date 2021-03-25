import ApplicationController from "./application_controller";
import {Tooltip} from 'bootstrap';

export default class extends ApplicationController {

    /**
     *
     */
    connect() {
        this.tooltip = new Tooltip(this.element, {
            boundary: 'window'
        })
    }
}
