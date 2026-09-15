import ApplicationController from "./application_controller";
import {
    BarChart,
    LineChart,
    MixedChart,
    PercentageChart,
    PieChart,
} from "@orchidsoftware/charts";

const charts = {
    bar: BarChart,
    line: LineChart,
    mixed: MixedChart,
    percentage: PercentageChart,
    pie: PieChart,
};

export default class extends ApplicationController {
    static targets = ["canvas"];
    static values = { config: Object };

    connect() {
        this.renderChart = () => this.render();
        if (document.readyState === "complete") {
            this.render();
        } else {
            window.addEventListener("load", this.renderChart, { once: true });
        }
    }

    configValueChanged() {
        if (this.chart) this.render();
    }

    canvasTargetConnected() {
        if (this.chart) this.render();
    }

    render() {
        this.chart?.destroy();
        this.chart = null;

        const { type, options, data } = this.configValue;
        this.element.dataset.chartType = type;
        const builder = charts[type].make(this.canvasTarget).labels(data.labels);

        Object.entries(options).forEach(([option, value]) => builder[option](value));
        data.datasets.forEach(dataset => builder.dataset(dataset));
        data.markers?.forEach(marker => builder.marker(marker));
        data.regions?.forEach(region => builder.region(region));

        this.chart = builder.render();
    }

    export(event) {
        event.preventDefault();
        this.chart?.download();
    }

    disconnect() {
        window.removeEventListener("load", this.renderChart);
        this.chart?.destroy();
        this.chart = null;
    }
}
