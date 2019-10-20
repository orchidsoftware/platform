import {Controller} from 'stimulus';
import Inputmask    from 'inputmask';

export default class extends Controller {
    get mask() {
        try {
            const maskData = this.data.get('mask');

            if (maskData === '') {
                return false;
            }

            const mask = JSON.parse(maskData);
            return {
                ...mask,
                // do unmask after inputmask.remove
                autoUnmask: mask.autoUnmask || mask.removeMaskOnSubmit || undefined
            }
        } catch (e) {
            return false;
        }
    }

    /**
     *
     */
    connect() {
        const element = this.element.querySelector('input');
        const _mask = this.mask;

        // mask
        if (_mask) {
            // removeMaskOnSubmit conflicts with remove, so we don’t use it
            // submit -> inputmask.remove -> removeMaskOnSubmit (timeout) -> failure
            const {removeMaskOnSubmit, ...mask} = _mask;
            Inputmask(mask).mask(element);

            if (removeMaskOnSubmit) {
                this.element.closest('form').addEventListener('orchid:screen-submit', () => {
                    element.inputmask.remove();
                });
            }
        }
    }
}
