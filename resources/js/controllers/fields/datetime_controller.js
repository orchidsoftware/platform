import Flatpickr from 'stimulus-flatpickr';
import rangePlugin from 'flatpickr/dist/plugins/rangePlugin';
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
     * @param selectedDates
     * @param dateStr
     * @param instance
     * @returns {*}
     */
    change(selectedDates, dateStr, instance) {
        return dateStr;
    }
}
