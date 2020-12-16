import { Controller } from 'stimulus';

export default class extends Controller {
    /**
     *
     */
    connect() {
        this.element
            .querySelector('input:not([hidden])')
            .indeterminate = this.data.get('indeterminate');
    }
}
