import flatpickr             from 'flatpickr';
import rangePlugin           from 'flatpickr/dist/plugins/rangePlugin';
import ApplicationController from './application_controller';
import 'flatpickr/dist/l10n';

export default class extends ApplicationController {

    /**
     *
     */
    connect() {
        const plugins = [];

        if (this.data.get('range')) {
            plugins.push(new rangePlugin({ input: this.data.get('range') }));
        }

        const configsAttributes = {
            enableTime: 'enable-time',
            time_24hr: 'time-24hr',
            allowInput: 'allow-input',
            dateFormat: 'date-format',
            noCalendar: 'no-calendar',
            minuteIncrement: 'minute-increment',
            hourIncrement: 'hour-increment',
            static: 'static',
            disableMobile: 'disable-mobile',
            inline: 'inline',
            position: 'position',
            shorthandCurrentMonth: 'shorthand-current-month',
            showMonths: 'show-months',
            allowEmpty: 'allowEmpty',
            placeholder: 'placeholder',
            enable: 'enable',
            disable: 'disable',
            maxDate: 'max-date',
            minDate: 'min-date',
        };

        const config = {
            locale: document.documentElement.lang,
            plugins,
        };

        Object.entries(configsAttributes).forEach(([key, value]) => {
            if (!this.data.has(key)) {
                return;
            }

            if (typeof this.data.get(value) !== 'string') {
                config[key] = this.data.get(value);
                return;
            }

            try {
                config[key] = JSON.parse(this.data.get(value));
            } catch (error) {
                config[key] = this.data.get(value);
            }
        });

        this.fp = flatpickr(this.element.querySelector('input'), config);
    }

    /**
     * Clear input time
     */
    clear() {
        this.fp.clear();
    }
}
