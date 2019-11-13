import StimulusFlatpickr from "stimulus-flatpickr";
import rangePlugin from 'flatpickr/dist/plugins/rangePlugin';
import 'flatpickr/dist/l10n';

export default class extends StimulusFlatpickr {
    connect() {
        const element = this.element.querySelector('input');
        this._initializeEvents();
        this._initializeOptions();
        this._initializeDateFormats();

        this.fp = flatpickr(element, {
            ...this.config
        });

        this._initializeElements();
    }

    initialize() {
        const plugins = [];
        if (this.data.get('range')) {
            plugins.push(new rangePlugin({input: this.data.get('range')}));
        }

        this.config = {
            locale: document.documentElement.lang,
            plugins,
        };
    }

    clear() {
        this.fp.clear();
    }
}
