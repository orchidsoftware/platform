import ApplicationController from "./application_controller";
import {Tooltip} from 'bootstrap';

export default class extends ApplicationController {


    /**
     *
     */
    connect() {
        this.tooltip = new Tooltip(this.element, {
            trigger : 'manual',
        })

        this.element.addListener('mouseOver', () => this.mouseOver())
        this.element.addListener('mouseOut', () => this.mouseOut())
    }
    /**
     *
     */
    mouseOver() {
        this.tooltip.show();
    }

    /**
     *
     */
    mouseOut() {
        this.tooltip.hide();
    }
}
