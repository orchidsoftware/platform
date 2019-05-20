import {Controller} from 'stimulus';
import {Chart}      from 'chart.js';

export default class extends Controller {

    static targets = [
        "canvas"
    ]

    /**
     *
     */
    connect() {
        var chartdata={
            type: this.data.get('type'),
            data: {
                labels: JSON.parse(this.data.get('labels')),
                datasets: JSON.parse(this.data.get('datasets')),
            },
            options: JSON.parse(this.data.get('options')),
        };
        chartdata['options']['title']['text']=this.data.get('title');
        if (this.data.get('setcolors')) {
            chartdata=this.setColor (chartdata);
        }
        this.chart = new Chart(this.canvasTarget, chartdata);
    }


    setColor (chartdata) {
        var chart = this;
        var helpers = Chart.helpers;

        var schemeClone = JSON.parse(this.data.get('colors'));
        length = schemeClone.length;

        // Set scheme colors
        chartdata.data.datasets.forEach(function(dataset, datasetIndex) {

            var colorIndex = datasetIndex % length;
            var color = schemeClone[colorIndex];

            // Object to store which color option is set
            dataset.colorschemes = {};

            switch (dataset.type || chart.data.get('type')) {
                // For line, radar and scatter chart, borderColor and backgroundColor (50% transparent) are set
                case 'line':
                case 'radar':
                case 'scatter':
                    if (typeof dataset.backgroundColor === 'undefined') {
                        dataset.backgroundColor = helpers.color(color).alpha(0.5).rgbString();
                        dataset.colorschemes.backgroundColor = true;
                    }
                    if (typeof dataset.borderColor === 'undefined') {
                        dataset.borderColor = color;
                        dataset.colorschemes.borderColor = true;
                    }
                    if (typeof dataset.pointBackgroundColor === 'undefined') {
                        dataset.pointBackgroundColor = helpers.color(color).alpha(0.5).rgbString();
                        dataset.colorschemes.pointBackgroundColor = true;
                    }
                    if (typeof dataset.pointBorderColor === 'undefined') {
                        dataset.pointBorderColor = color;
                        dataset.colorschemes.pointBorderColor = true;
                    }
                    break;
                // For doughnut and pie chart, backgroundColor is set to an array of colors
                case 'doughnut':
                case 'pie':
                    if (typeof dataset.backgroundColor === 'undefined') {
                        dataset.backgroundColor = dataset.data.map(function(data, dataIndex) {
                            colorIndex = dataIndex % length;
                            return schemeClone[colorIndex];
                        });
                        dataset.colorschemes.backgroundColor = true;
                    }
                    break;
                // For the other chart, only backgroundColor is set
                default:
                    if (typeof dataset.backgroundColor === 'undefined') {
                        dataset.backgroundColor = color;
                        dataset.colorschemes.backgroundColor = true;
                    }
                    break;
            }
        });
        return chartdata;
    }

}
