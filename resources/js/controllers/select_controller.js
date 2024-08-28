import TomSelect from 'tom-select';
import ApplicationController from './application_controller';

export default class extends ApplicationController {
    /**
     *
     */
    connect() {
        if (document.documentElement.hasAttribute('data-turbo-preview')) {
            return;
        }

        const select = this.element.querySelector('select');
        const plugins = ['change_listener'];

        if (select.hasAttribute('multiple')) {
            plugins.push('remove_button');
            plugins.push('clear_button');
        }

        const options = {
            create: this.data.get('allow-add') === 'true',
            allowEmptyOption: true,
            maxOptions: 'null',
            placeholder: select.getAttribute('placeholder') === 'false' ? '' : select.getAttribute('placeholder'),
            preload: true,
            plugins,
            maxItems: select.getAttribute('maximumSelectionLength') || select.hasAttribute('multiple') ? null : 1,
            render: {
                option_create: (data, escape) => `<div class="create">${this.data.get('message-add')} <strong>${escape(data.input)}</strong>&hellip;</div>`,
                no_results: () => `<div class="no-results">${this.data.get('message-notfound')}</div>`,
            },
            onDelete: () => !! this.data.get('allow-empty'),
            onItemAdd: function() {
                this.setTextboxValue('');
                this.refreshOptions(false);
            }
        };

        const ajaxOptionsUrl = select.getAttribute('ajaxoptionsurl');

        if (ajaxOptionsUrl) {
            options['valueField']  = select.getAttribute('ajaxvaluefield') ?? 'value';
            options['labelField']  = select.getAttribute('ajaxlabelfield') ?? 'label';
            options['searchField'] = [options['valueField'], options['labelField']];

            options['load'] = async (query, callback) => {
                axios
                .get(ajaxOptionsUrl, { query })
                .then((response) => {
                    console.log(1);
                    callback(response.data.items);
                });
            };
        
            options['render'] = {
                option: function(item, escape) {
                    return `<div class="py-2 d-flex">
                                <div>
                                    <div class="mb-1">
                                        <span class="h4">
                                            ${ escape(item[options['labelField']]) }
                                        </span>
                                    </div>
                                </div>
                            </div>`;
                },
                item: function(item, escape) {
                    return `<div class="py-2 d-flex">
                                <div>
                                    <div class="mb-1">
                                        <span class="h4">
                                            ${ escape(item[options['labelField']]) }
                                        </span>
                                    </div>
                                </div>
                            </div>`;
                }
            }
        }

        this.choices = new TomSelect(select, options);
    }

    /**
     *
     */
    disconnect() {
        this.choices?.destroy();
    }
}
