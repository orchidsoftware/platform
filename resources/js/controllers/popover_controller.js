import {Controller} from 'stimulus';
import {Popover} from 'bootstrap';

export default class extends Controller {
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
