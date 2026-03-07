import TomSelect from 'tom-select';
import ApplicationController from './application_controller';

export default class extends ApplicationController {
    static targets = ['select'];

    static values = {
        placeholder: { type: String, default: '' },
        allowEmpty: { type: String, default: '' },
        messageNotfound: { type: String, default: 'No results found' },
        allowAdd: { type: String, default: 'false' },
        messageAdd: { type: String, default: 'Add' },
        route: { type: String, default: '' },
        model: { type: String, default: '' },
        name: { type: String, default: '' },
        key: { type: String, default: '' },
        scope: { type: String, default: '' },
        append: { type: String, default: '' },
        searchColumns: { type: String, default: '' },
        chunk: { type: String, default: '10' },
    };

    connect() {
        const select = this.hasSelectTarget ? this.selectTarget : this.element.querySelector('select');
        const plugins = ['change_listener'];

        if (select.hasAttribute('multiple')) {
            plugins.push('remove_button');
            plugins.push('clear_button');
        }

        const isLazy = Boolean(this.routeValue);
        const options = {
            create: this.allowAddValue === 'true',
            allowEmptyOption: true,
            placeholder: select.getAttribute('placeholder') === 'false' ? '' : (this.placeholderValue || select.getAttribute('placeholder') || ''),
            preload: isLazy ? 'focus' : true,
            plugins,
            maxOptions: isLazy ? this.chunkValue : 'null',
            maxItems: select.getAttribute('maximumSelectionLength') || select.getAttribute('data-maximum-selection-length') || (select.hasAttribute('multiple') ? null : 1),
            render: {
                option_create: (data, escape) => `<div class="create">${this.messageAddValue} <strong>${escape(data.input)}</strong>&hellip;</div>`,
                no_results: () => `<div class="no-results">${this.messageNotfoundValue}</div>`,
            },
            onDelete: () => Boolean(this.allowEmptyValue),
            onItemAdd: function() {
                this.setTextboxValue('');
                this.refreshOptions(false);
            }
        };

        if (isLazy) {
            options.valueField = 'value';
            options.labelField = 'label';
            options.searchField = [];
            options.sortField = [{ field: '$order' }, { field: '$score' }];
            options.load = (query, callback) => this.search(query, callback);
        }

        this.choices = new TomSelect(select, options);
    }

    search(search, callback) {
        axios.post(this.routeValue, {
            search,
            model: this.modelValue,
            name: this.nameValue,
            key: this.keyValue,
            scope: this.scopeValue,
            append: this.appendValue,
            searchColumns: this.searchColumnsValue,
            chunk: this.chunkValue,
        })
            .then((response) => {
                this.choices.clearOptions();
                callback(response.data);
            });
    }

    disconnect() {
        this.choices?.destroy();
    }
}
