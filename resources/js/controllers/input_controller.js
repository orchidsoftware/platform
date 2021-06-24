import ApplicationController from "./application_controller";
import Inputmask from 'inputmask';

export default class extends ApplicationController {

    /**
     *
     * @returns {string|object}
     */
    get mask() {
        let mask = this.data.get('mask');

        try {
            mask = JSON.parse(mask);
            mask.autoUnmask = mask.autoUnmask || mask.removeMaskOnSubmit || undefined;

            return mask;
        } catch (e) {
            // as string
            return mask;
        }
    }

    /**
     *
     */
    connect() {
        const element = this.element.querySelector('input');
        let mask = this.mask;

        // mask
        if (mask.length < 1) {
            return;
        }

        let form = element.form || this.element.closest('form')

        form.addEventListener('orchid:screen-submit', () => {
            if (mask.removeMaskOnSubmit) {
                element.inputmask.remove();
            }
        });

        Inputmask(mask).mask(element);
    }
}
