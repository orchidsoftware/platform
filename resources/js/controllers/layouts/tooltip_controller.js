import {Controller} from 'stimulus';
import {Tooltip} from 'bootstrap'

export default class extends Controller {

    /**
     *
     */
    mouseOver() {
        new Tooltip(this.element);
    }
}
