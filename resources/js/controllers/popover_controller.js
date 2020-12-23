import { Controller } from 'stimulus';

export default class extends Controller {
    /**
     *
     */
    connect() {
        $(this.element.querySelectorAll('a')).popover();
    }

    /**
     *
     * @param event
     */
    trigger(event) {
        event.preventDefault();
        $(this.element).popover('toggle');
    }
}
