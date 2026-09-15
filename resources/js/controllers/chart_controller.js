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

    render() {
        const config = this.configValue;
        const builder = charts[config.type]
            .make(this.canvasTarget)
            .labels(config.labels)
            .height(config.height)
            .colors(config.colors);
        const configureLine = line =>
            line
                .area(config.line.area)
                .dots(config.line.dots)
                .line(config.line.line)
                .dotSize(config.line.dotSize)
                .smooth(config.line.smooth);

        config.datasets.forEach(dataset => {
            if (config.type === "mixed" && dataset.chartType === "line") {
                builder.dataset(dataset, configureLine);
            } else {
                builder.dataset(dataset);
            }
        });

        if (config.type === "line") configureLine(builder);
        if (config.type === "bar") builder.stacked(config.stacked);
        if (["pie", "percentage"].includes(config.type)) {
            builder.maxSlices(config.maxSlices);
        } else {
            builder.valueLabels(true);
            config.markers.forEach(marker => builder.marker(marker));
        }
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
