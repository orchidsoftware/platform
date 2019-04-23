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
                url: () => this.data.get('route'),
                dataType: 'json',
                processResults: (data) => {

                    let selectValues = $(select).val();
                    selectValues = Array.isArray(selectValues) ? selectValues : [selectValues];

                    let dataFormat = [];

                    Object.values(data).forEach((value, key) => {

                        let isSelect = selectValues.find(element => parseInt(element) === key);

                        if (selectValues.length !== 0 && isSelect === undefined) {
                            return;
                        }

                        dataFormat.push({
                            'id': key,
                            'text': value
                        });
                    });

                    return {
                        results: dataFormat
                    };
                },
                data: (params) => {
                    return {
                        search: params.term,
                        model: this.data.get('model'),
                        name: this.data.get('name'),
                        key: this.data.get('key'),
                    };
                }
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

        //if (!this.data.get('value')) {
            //return;
        //}

        axios.post(this.data.get('route')).then((response) => {
            $(select)
                .append(new Option(response.data.text, response.data.id, true, true))
                .trigger('change');
        });

        document.addEventListener('turbolinks:before-cache', () => {
            $(select).select2('destroy');
        }, {once: true});
    }
}
