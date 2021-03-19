import ApplicationController from "./application_controller";
import {Chart} from 'frappe-charts/dist/frappe-charts.min.esm';

export default class extends ApplicationController {

    /**
     *
     */
    connect() {
        this.chart = new Chart(this.data.get('parent'), {
            title: this.data.get('title'),
            data: {
                labels: JSON.parse(this.data.get('labels')),
                datasets: JSON.parse(this.data.get('datasets')),
                yMarkers: JSON.parse(this.data.get('markers')),
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

        this.drawEvent = () => setTimeout(() => {
            this.chart.draw();
        }, 100);

        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', this.drawEvent);
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
        this.chart.destroy();
        $(document).off('shown.bs.tab', 'a[data-toggle="tab"]', this.drawEvent);
    }
}
