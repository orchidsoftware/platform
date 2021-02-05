import {Controller} from 'stimulus';
import {Tooltip} from 'bootstrap';

export default class extends Controller {


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
