import Flatpickr from 'stimulus-flatpickr';
import rangePlugin from 'flatpickr/dist/plugins/rangePlugin.js';
import 'flatpickr/dist/l10n';

export default class extends Flatpickr {
    /**
     *
     */
    initialize() {
        const plugins = [];
        if (this.data.get('range')) {
            plugins.push(new rangePlugin({ input: this.data.get('range') }));
        }

        this.config = {
            locale: document.documentElement.lang,
            plugins,
        };
    }

    /**
     *
     */
    connect() {
        super.connect();
    }

    /**
     *
     * @param selectedDates
     * @param dateStr
     * @param instance
     * @returns {*}
     */
    change(selectedDates, dateStr, instance) {
        return dateStr;
    }
}
