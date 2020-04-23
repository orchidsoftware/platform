import { Controller } from 'stimulus';
import { Chart } from 'frappe-charts/dist/frappe-charts.min.esm';

export default class extends Controller {

    /**
     *
     */
    connect() {
        this.chart = new Chart(this.data.get('parent'), {
            title: this.data.get('title'),
            data: {
                labels: JSON.parse(this.data.get('labels')),
                datasets: JSON.parse(this.data.get('datasets')),
            },
            type: this.data.get('type'),
            height: this.data.get('height'),

            maxSlices: JSON.parse(this.data.get('max-slices')),

            valuesOverPoints: JSON.parse(this.data.get('values-over-points')),
            axisOptions: JSON.parse(this.data.get('axis-options')),
            barOptions:  JSON.parse(this.data.get('bar-options')),
            lineOptions:  JSON.parse(this.data.get('line-options')),

            colors: JSON.parse(this.data.get('colors')),
        });

        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', this.drawEvent());
    }

    /**
     *
     * @returns {Function}
     */
    drawEvent() {
        return () => {
            this.chart.draw();
        };
    }

    /**
     *
     */
    export() {
        this.chart.export();
    }

    /**
     *
     */
    disconnect() {
        $(document).off('shown.bs.tab', 'a[data-toggle="tab"]', this.drawEvent());
    }
}
