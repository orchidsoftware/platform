import {Controller} from 'stimulus';
import {Chart}      from 'frappe-charts/dist/frappe-charts.esm';

export default class extends Controller {
    /**
     *
     */
    connect() {
        const chart = new Chart(this.data.get('parent'), {
            title: this.data.get('title'),
            data: {
                labels: JSON.parse(this.data.get('labels')),
                datasets: JSON.parse(this.data.get('datasets')),
            },
            type: this.data.get('type'),
            height: this.data.get('height'),

            colors: JSON.parse(this.data.get('colors')),
        });

        /*
        let resize = () => setTimeout(() => {
            console.log('test');
            chart.draw(!0)
        }, 1);

        window.addEventListener('resize', () => setTimeout(() => {
            console.log('test');
            chart.draw(!0)
        }, 1));

        window.removeEventListener('resize', () => setTimeout(() => {
            console.log('test');
            chart.draw(!0)
        }, 1))
        */
    }
}
