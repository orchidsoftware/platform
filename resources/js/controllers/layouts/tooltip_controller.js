import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     *
     */
    mouseOver() {
        $(this.element).tooltip('enable');
    }
}
