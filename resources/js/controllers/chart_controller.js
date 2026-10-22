import ApplicationController from "./application_controller";
import {
    BarChart,
    LineChart,
    MixedChart,
    PercentageChart,
    PieChart,
} from "@orchidsoftware/charts";

export default class extends ApplicationController {
    static targets = ["canvas"];
    static values = {
        type: { type: String, default: "line" },
        height: { type: Number, default: 250 },
        labels: Array,
        datasets: Array,
        markers: Array,
        regions: Array,
        width: Number,
        colors: Array,
        legend: Boolean,
        tooltip: Boolean,
        axes: Boolean,
        grid: Boolean,
        valueLabels: Boolean,
        frameless: { type: Boolean, default: false },
        smooth: { type: Boolean, default: true },
        dots: Boolean,
        dotSize: { type: Number, default: 3 },
        line: { type: Boolean, default: true },
        area: { type: Boolean, default: false },
        gradient: { type: Boolean, default: false },
        gradientFromOpacity: { type: Number, default: 0.42 },
        gradientToOpacity: { type: Number, default: 0 },
        strokeWidth: { type: Number, default: 2 },
        stacked: { type: Boolean, default: false },
        horizontal: { type: Boolean, default: false },
        radius: { type: Number, default: 3 },
        maxSlices: { type: Number, default: 20 },
        startAngle: { type: Number, default: 0 },
        padAngle: { type: Number, default: 1.5 },
    };

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

    labelsValueChanged() {
        this.render();
    }

    datasetsValueChanged() {
        this.render();
    }

    markersValueChanged() {
        this.render();
    }

    regionsValueChanged() {
        this.render();
    }

    render() {
        if (!this.canvas || document.readyState !== "complete") return;

        if (!this.hasLabelsValue || !this.hasDatasetsValue) {
            throw new Error("Chart requires labels and datasets values.");
        }

        const builder = this.createBuilder()
            .height(this.heightValue)
            .labels(this.labelsValue);
        if (this.hasWidthValue) builder.width(this.widthValue);
        if (this.hasColorsValue) builder.colors(this.colorsValue);
        if (this.hasLegendValue) builder.legend(this.legendValue);
        if (this.hasTooltipValue) builder.tooltip(this.tooltipValue);
        if (this.hasAxesValue) builder.axes(this.axesValue);
        if (this.hasGridValue) builder.grid(this.gridValue);
        if (this.hasValueLabelsValue)
            builder.valueLabels(this.valueLabelsValue);
        if (this.hasDotsValue) builder.dots(this.dotsValue);

        this.datasetsValue.forEach(dataset => builder.dataset(dataset));
        this.markersValue.forEach(marker => builder.marker(marker));
        this.regionsValue.forEach(region => builder.region(region));

        this.chart?.destroy();
        this.chart = null;
        this.chart = builder.render();
    }

    get gradient() {
        return this.gradientValue
            ? {
                  fromOpacity: this.gradientFromOpacityValue,
                  toOpacity: this.gradientToOpacityValue,
              }
            : false;
    }

    createBuilder() {
        switch (this.typeValue) {
            case "bar":
                return BarChart.make(this.canvas)
                    .frameless(this.framelessValue)
                    .stacked(this.stackedValue)
                    .horizontal(this.horizontalValue)
                    .radius(this.radiusValue);
            case "line":
                return LineChart.make(this.canvas)
                    .frameless(this.framelessValue)
                    .smooth(this.smoothValue)
                    .line(this.lineValue)
                    .area(this.areaValue)
                    .dotSize(this.dotSizeValue)
                    .strokeWidth(this.strokeWidthValue)
                    .gradient(this.gradient);
            case "mixed":
                return MixedChart.make(this.canvas)
                    .frameless(this.framelessValue)
                    .gradient(this.gradient);
            case "percentage":
                return PercentageChart.make(this.canvas).maxSlices(
                    this.maxSlicesValue
                );
            case "pie":
                return PieChart.make(this.canvas)
                    .maxSlices(this.maxSlicesValue)
                    .startAngle(this.startAngleValue)
                    .padAngle(this.padAngleValue);
            default:
                throw new Error(`Unsupported chart type: ${this.typeValue}`);
        }
    }

    export() {
        this.chart?.download();
    }
}
