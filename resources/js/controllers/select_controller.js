import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    /**
     *
     */
    connect() {
        if (document.documentElement.hasAttribute('data-turbo-preview')) {
            return;
        }
        const select = this.element.querySelector('select');

        $(select).select2({
            width: '100%',
            allowClear: !select.hasAttribute('required'),
            placeholder: select.getAttribute('placeholder') || '',
            maximumSelectionLength: select.getAttribute('maximumSelectionLength') || 0,
            ...select.hasAttribute('tags') ? { tags: true } : '',
            theme: 'bootstrap',
        });

        // force change event for https://github.com/select2/select2/issues/1908
        let forceChange = () => {
            setTimeout(() => {
                select.dispatchEvent(new Event('change'));
            }, 100);
        }

        // if inside bootstrap dropdown,
        // prevent the dropdown from hiding when clicking on search field
		// https://github.com/orchidsoftware/platform/issues/1767
        if ($(select).closest('.dropdown-menu').length) {
            $(select)
                .data('select2')
                .dropdown.$dropdown.find('.select2-search__field').click(e => e.stopPropagation());
        }

        $(select).on('select2:select', forceChange);
        $(select).on('select2:unselect', forceChange);
        $(select).on('select2:clear', forceChange);

        document.addEventListener('turbo:before-cache', () => {
            if (typeof $(select) !== 'undefined' && $('select').data('select2')) {
                $(select).select2('destroy');
            }
        }, { once: true });
    }
}
