import { Controller } from 'stimulus';

export default class extends Controller {
    /**
     *
     */
    connect() {
        const select = this.element.querySelector('select');

        $(select).select2({
            width: '100%',
            theme: 'bootstrap',
        });
    }
}
