import {Controller} from 'stimulus';
import Inputmask    from 'inputmask';

export default class extends Controller {
    /**
     *
     */
    connect() {
        const element = this.element.querySelector('input');
        let mask = this.data.get('mask');

        try {
            mask = JSON.parse(mask);
        } catch (e) {
            // default
        }
        if (mask != '') {
          Inputmask(mask).mask(element);
        }
    }
}
