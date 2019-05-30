import { Controller } from 'stimulus';

export default class extends Controller {
    /**
     *
     */
    connect() {
        if (document.documentElement.hasAttribute('data-turbolinks-preview')) {
            return;
        }
        const select = this.element.querySelector('select');

        $(select).select2({
            width: '100%',
            allowClear: !select.hasAttribute('required'),
            placeholder: select.getAttribute('placeholder') || '',
            theme: 'bootstrap',
        });


        document.addEventListener('turbolinks:before-cache', () => {
            $(select).select2('destroy');
        }, { once: true });
    }
}
