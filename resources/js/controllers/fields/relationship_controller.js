import {Controller} from 'stimulus';

export default class extends Controller {
    /**
     *
     */
    connect() {
        const select = this.element.querySelector('select');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });

        $(select).select2({
            theme: "bootstrap",
            ajax: {
                type: "POST",
                cache: true,
                delay: 250,
                url: () => {
                    return this.data.get('url');
                },
                dataType: 'json'
            },
            selectOnClose: true,
            placeholder: this.data.get('placeholder'),
        });

        if (!this.data.get('value')) {
            return;
        }

        axios.post(this.data.get('url-value')).then((response) => {
            $(select)
                .append(new Option(response.data.text, response.data.id, true, true))
                .trigger('change');
        });
    }
}
