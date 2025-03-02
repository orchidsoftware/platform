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

        this.choices = this.initTomSelect();
    }

    initTomSelect() {
        const select = this.element.querySelector('select');
        const plugins = ['change_listener'];

        if (select.hasAttribute('multiple')) {
            plugins.push('remove_button', 'clear_button');
        }

        const options = {
            create: this.data.get('allow-add') === 'true',
            allowEmptyOption: true,
            placeholder: select.getAttribute('placeholder') === 'false' ? '' : select.getAttribute('placeholder'),
            plugins,
            maxItems: select.getAttribute('maximumSelectionLength') || (select.hasAttribute('multiple') ? null : 1),
            render: {
                option_create: (data, escape) => `<div class="create">${this.data.get('message-add')} <strong>${escape(data.input)}</strong>&hellip;</div>`,
                no_results: () => `<div class="no-results">${this.data.get('message-notfound')}</div>`
            },
            onDelete: () => !!this.data.get('allow-empty'),
            onItemAdd() {
                this.setTextboxValue('');
                this.refreshOptions(false);
            }
        };

        if (this.data.get('query')) {
            Object.assign(options, {
                preload: 'focus',
                maxOptions: this.data.get('chunk'),
                valueField: 'value',
                labelField: 'label',
                searchField: [],
                sortField: [{ field: '$order' }, { field: '$score' }],
                load: (query, callback) => this.search(query, callback)
            });
        } else {
            options.preload = true;
        }

        return new TomSelect(select, options);
    }

    /**
     *
     */
    disconnect() {
        this.choices?.destroy();
    }

    /**
     *
     * @param search
     * @param callback
     */
    search(search, callback) {
        const display = this.data.get('display');
        const key = this.data.get('key');
        const query = this.data.get('query');

        axios.post(this.data.get('route'), {
            display,
            key,
            query,
            search,
        })
            .then((response) => {
                this.choices.clearOptions();
                callback(response.data);
            });
    }

}
