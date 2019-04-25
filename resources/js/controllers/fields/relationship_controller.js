import {Controller} from 'stimulus';

export default class extends Controller {
    /**
     *
     */
    connect() {
        const select = this.element.querySelector('select');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
            },
        });

        $(select).select2({
            theme: 'bootstrap',
            allowClear: !select.hasAttribute('required'),
            ajax: {
                type: 'POST',
                cache: true,
                delay: 250,
                url: () => this.data.get('url'),
                dataType: 'json',
            },
            templateResult: function (option) {
                if (option.html) {
                    return option.html;
                }

                return option.text;
            },
            escapeMarkup: function (m) {
                return m;
            },
            placeholder: select.getAttribute('placeholder') || '',
        }).on('select2:unselecting', function () {
            $(this).data('state', 'unselected');
        }).on('select2:opening', function (e) {
            if ($(this).data('state') === 'unselected') {
                e.preventDefault();
                $(this).removeData('state');
            }
        });

        if (!this.data.get('value')) {
            return;
        }

        axios.post(this.data.get('url-value')).then((response) => {
            $(select)
                .append(new Option(response.data.text, response.data.id, true, true))
                .trigger('change');
        });

        document.addEventListener('turbolinks:before-cache', () => {
            $(select).select2('destroy');
        }, {once: true});
    }
}
