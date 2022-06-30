import TomSelect             from 'tom-select';
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
            allowEmptyOption: true,
            placeholder: select.getAttribute('placeholder') === 'false' ? '' : select.getAttribute('placeholder'),
            preload: true,
            plugins: plugins,
            maxOptions: this.data.get('chunk'),
            maxItems: select.getAttribute('maximumSelectionLength') || select.hasAttribute('multiple') ? null : 1,
            valueField: 'value',
            labelField: 'label',
            searchField: 'label',
            render: {
                option_create: (data, escape) => '<div class="create">Ajouter <strong>' + escape(data.input) + '</strong>&hellip;</div>',
                no_results: (data, escape) => '<div class="no-results">Нет результатов</div>',
            },
            load: (query, callback) => this.search(query, callback),
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
                callback(response.data.items);
            });
    }

    /**
     *
     */
    disconnect() {
        this.choices.destroy();
    }
}
