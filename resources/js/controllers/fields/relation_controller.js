import {Controller} from 'stimulus';

export default class extends Controller {
    /**
     *
     */
    connect() {
        const select = this.element.querySelector('select');
        const model = this.data.get('model');
        const name = this.data.get('name');
        const key = this.data.get('key');


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

                        if(selectValues.map(Number).includes(key)){
                            return;
                        }

                        dataFormat.push({
                            'id': key,
                            'text': value,
                        });
                    });

                    return {
                        results: dataFormat
                    };
                },
                data: (params) => {
                    return {
                        search: params.term,
                        model: model,
                        name: name,
                        key: key,
                    };
                }
            },
            placeholder: select.getAttribute('placeholder') || '',
        });

        if (!this.data.get('value')) {
            return;
        }

        let values = JSON.parse(this.data.get('value'));

        values.forEach((model) => {
            $(select)
                .append(new Option(model.text, model.id, true, true))
                .trigger('change');
        });

        document.addEventListener('turbolinks:before-cache', () => {
            $(select).select2('destroy');
        }, {once: true});
    }
}
