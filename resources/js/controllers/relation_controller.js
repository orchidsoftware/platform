import TomSelect from 'tom-select';
import ApplicationController from './application_controller';

export default class extends ApplicationController {
    static get targets() {
        return ['select'];
    }

    connect() {
        if (document.documentElement.hasAttribute('data-turbo-preview')) {
            return;
        }

        const select = this.selectTarget;
        const plugins = ['change_listener'];

        if (select.hasAttribute('multiple')) {
            plugins.push('remove_button');
            plugins.push('clear_button');
        }

        this.choices = new TomSelect(select, {
            create: this.data.get('allow-add') === 'true',
            allowEmptyOption: true,
            placeholder: select.getAttribute('placeholder') === 'false' ? '' : select.getAttribute('placeholder'),
            preload: 'focus',
            plugins,
            maxOptions: this.data.get('chunk'),
            maxItems: select.getAttribute('maximumSelectionLength') || select.hasAttribute('multiple') ? null : 1,
            valueField: 'value',
            labelField: 'label',
            searchField: [],
            sortField: [{field:'$order'},{field:'$score'}],
            render: {
                option_create: (data, escape) => `<div class="create">${this.data.get('message-add')} <strong>${escape(data.input)}</strong>&hellip;</div>`,
                no_results: () => `<div class="no-results">${this.data.get('message-notfound')}</div>`,
            },
            onDelete: () => !! this.data.get('allow-empty'),
            load: (query, callback) => this.search(query, callback),
            onItemAdd: function() {
                this.setTextboxValue('');
                this.refreshOptions(false);
            }
        });
    }

    /**
     *
     * @param search
     * @param callback
     */
    search(search, callback) {
        const model = this.data.get('model');
        const name = this.data.get('name');
        const key = this.data.get('key');
        const scope = this.data.get('scope');
        const append = this.data.get('append');
        const searchColumns = this.data.get('search-columns');
        const chunk = this.data.get('chunk');

        axios.post(this.data.get('route'), {
            search,
            model,
            name,
            key,
            scope,
            append,
            searchColumns,
            chunk,
        })
        .then((response) => {
            this.choices.clearOptions();
            callback(response.data);
        });
    }

    /**
     *
     */
    disconnect() {
        this.choices?.destroy();
    }
}
