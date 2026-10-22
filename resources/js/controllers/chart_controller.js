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

    canvasTargetConnected(canvas) {
        this.canvas = canvas;
        this.render();
    }

    canvasTargetDisconnected(canvas) {
        if (this.canvas !== canvas) return;

        this.chart?.destroy();
        this.chart = null;
        this.canvas = null;
    }

    configValueChanged() {
        this.render();
    }

    render() {
        if (!this.canvas || document.readyState !== "complete") return;

        this.chart?.destroy();
        this.chart = null;

        const { type, options, data } = this.configValue;
        this.element.dataset.chartType = type;
        const builder = charts[type].make(this.canvas).labels(data.labels);

        Object.entries(options).forEach(([option, value]) =>
            builder[option](value)
        );
        data.datasets.forEach(dataset => builder.dataset(dataset));
        data.markers?.forEach(marker => builder.marker(marker));
        data.regions?.forEach(region => builder.region(region));

        this.chart = builder.render();
    }

    export() {
        this.chart?.download();
    }
}
