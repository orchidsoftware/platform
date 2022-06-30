import TomSelect             from 'tom-select';
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

        this.choices = new TomSelect(select, {
            allowEmptyOption: true,
            placeholder: select.getAttribute('placeholder') === 'false' ? '' : select.getAttribute('placeholder'),
            preload: true,
            plugins: plugins,
            maxItems: select.getAttribute('maximumSelectionLength') || select.hasAttribute('multiple') ? null : 1,
            render: {
                option_create: (data, escape) => '<div class="create">Ajouter <strong>' + escape(data.input) + '</strong>&hellip;</div>',
                no_results: (data, escape) => '<div class="no-results">Нет результатов</div>',
            },
        });
    }

    /**
     *
     */
    disconnect() {
        this.choices.destroy();
    }
}
