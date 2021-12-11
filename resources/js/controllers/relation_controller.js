import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static get targets() {
        return ['select'];
    }

    connect() {
        if (document.documentElement.hasAttribute("data-turbo-preview")) {
            return;
        }

        const select = this.selectTarget;
        const model = this.data.get('model');
        const name = this.data.get('name');
        const key = this.data.get('key');
        const scope = this.data.get('scope');
        const append = this.data.get('append');
        const searchColumns = this.data.get('search-columns');
        const chunk = this.data.get('chunk');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
            },
        });

        const parent = $(select).closest(".dropdown-menu, div");

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

                    return {
                        results: Object.keys(data).reduce((res, id) => {
                            if (selectValues.includes(id.toString())) {
                                return res;
                            }

                            return [...res, {
                                id,
                                text: data[id],
                            }];
                        }, []),
                    };
                },
                data: params => ({
                    search: params.term,
                    model,
                    name,
                    key,
                    scope,
                    append,
                    searchColumns,
                    chunk,
                }),
            },
            placeholder: select.getAttribute('placeholder') || '',
            dropdownParent: parent.length ? parent : undefined,
        });

        $(select).on('select2:open', () => {
            window.setTimeout(function() {
                $('.select2-container--open .select2-search__field').get(0).focus();
            }, 200);
        });

        // force change event for https://github.com/select2/select2/issues/1908
        let forceChange = () => setTimeout(() => {
            select.dispatchEvent(new Event('change'));
        }, 100);

        $(select).on('select2:select', forceChange);
        $(select).on('select2:unselect', forceChange);
        $(select).on('select2:clear', forceChange);

        if (!this.data.get('value')) {
            return;
        }

        const values = JSON.parse(this.data.get('value'));

        values.forEach((value) => {
            $(select)
                .append(new Option(value.text, value.id, true, true))
                .trigger('change');
        });

        document.addEventListener('turbo:before-cache', () => {
            if (typeof $(select) !== 'undefined') {
                $(select).select2('destroy');
            }
        }, { once: true });
    }
}
