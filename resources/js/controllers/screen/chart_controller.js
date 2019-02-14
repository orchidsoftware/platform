import {Controller} from 'stimulus';
import {Chart}      from 'frappe-charts/dist/frappe-charts.min.esm';

export default class extends Controller {
    /**
     *
     */
    connect() {
        new Chart(this.data.get('parent'), {
            title: this.data.get('title'),
            data: {
                labels: JSON.parse(this.data.get('labels')),
                datasets: JSON.parse(this.data.get('datasets')),
            },
            type: this.data.get('type'),
            height: this.data.get('height'),

            colors: JSON.parse(this.data.get('colors')),
        });
    }

    /**
     * @see https://github.com/frappe/charts/issues/212
     */
    disconnect() {
        window.addEventListener('resize', (event) => {
            event.stopPropagation();
        }, true);

        window.addEventListener('orientationchange', (event) => {
            event.stopPropagation();
        }, true);
    }
}
