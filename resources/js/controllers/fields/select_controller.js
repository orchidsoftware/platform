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
            ...select.hasAttribute('tags') ? { tags: true } : '',
            theme: 'bootstrap',
        });



        // force change event for https://github.com/select2/select2/issues/1908
        let forceChange = () => {
            setTimeout(() => {
                select.dispatchEvent(new Event('change'));
            }, 100);
        }
        $(select).on('select2:select', forceChange);
        $(select).on('select2:unselect', forceChange);
        $(select).on('select2:clear', forceChange);



        document.addEventListener('turbolinks:before-cache', () => {
            if (typeof $(select) !== 'undefined') {
                $(select).select2('destroy');
            }
        }, { once: true });
    }
}
