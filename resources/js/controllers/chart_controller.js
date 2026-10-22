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
        frameless: Boolean,
        smooth: Boolean,
        dots: Boolean,
        dotSize: Number,
        line: Boolean,
        area: Boolean,
        gradient: Boolean,
        gradientFromOpacity: Number,
        gradientToOpacity: Number,
        strokeWidth: Number,
        stacked: Boolean,
        horizontal: Boolean,
        radius: Number,
        maxSlices: Number,
        startAngle: Number,
        padAngle: Number,
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

    typeValueChanged() {
        this.render();
    }

    heightValueChanged() {
        this.render();
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

    widthValueChanged() {
        this.render();
    }

    colorsValueChanged() {
        this.render();
    }

    legendValueChanged() {
        this.render();
    }

    tooltipValueChanged() {
        this.render();
    }

    axesValueChanged() {
        this.render();
    }

    gridValueChanged() {
        this.render();
    }

    valueLabelsValueChanged() {
        this.render();
    }

    framelessValueChanged() {
        this.render();
    }

    smoothValueChanged() {
        this.render();
    }

    dotsValueChanged() {
        this.render();
    }

    dotSizeValueChanged() {
        this.render();
    }

    lineValueChanged() {
        this.render();
    }

    areaValueChanged() {
        this.render();
    }

    gradientValueChanged() {
        this.render();
    }

    gradientFromOpacityValueChanged() {
        this.render();
    }

    gradientToOpacityValueChanged() {
        this.render();
    }

    strokeWidthValueChanged() {
        this.render();
    }

    stackedValueChanged() {
        this.render();
    }

    horizontalValueChanged() {
        this.render();
    }

    radiusValueChanged() {
        this.render();
    }

    maxSlicesValueChanged() {
        this.render();
    }

    startAngleValueChanged() {
        this.render();
    }

    padAngleValueChanged() {
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
        if (this.hasFramelessValue) builder.frameless(this.framelessValue);
        if (this.hasSmoothValue) builder.smooth(this.smoothValue);
        if (this.hasDotsValue) builder.dots(this.dotsValue);
        if (this.hasDotSizeValue) builder.dotSize(this.dotSizeValue);
        if (this.hasLineValue) builder.line(this.lineValue);
        if (this.hasAreaValue) builder.area(this.areaValue);
        if (this.hasStrokeWidthValue)
            builder.strokeWidth(this.strokeWidthValue);
        if (this.hasStackedValue) builder.stacked(this.stackedValue);
        if (this.hasHorizontalValue) builder.horizontal(this.horizontalValue);
        if (this.hasRadiusValue) builder.radius(this.radiusValue);
        if (this.hasMaxSlicesValue) builder.maxSlices(this.maxSlicesValue);
        if (this.hasStartAngleValue) builder.startAngle(this.startAngleValue);
        if (this.hasPadAngleValue) builder.padAngle(this.padAngleValue);

        if (
            this.hasGradientValue ||
            this.hasGradientFromOpacityValue ||
            this.hasGradientToOpacityValue
        ) {
            const gradient = {};
            if (this.hasGradientFromOpacityValue)
                gradient.fromOpacity = this.gradientFromOpacityValue;
            if (this.hasGradientToOpacityValue)
                gradient.toOpacity = this.gradientToOpacityValue;
            builder.gradient(
                this.hasGradientValue && !this.gradientValue
                    ? false
                    : Object.keys(gradient).length
                      ? gradient
                      : true
            );
        }

        this.datasetsValue.forEach(dataset => builder.dataset(dataset));
        this.markersValue.forEach(marker => builder.marker(marker));
        this.regionsValue.forEach(region => builder.region(region));

        this.chart?.destroy();
        this.chart = null;
        this.chart = builder.render();
    }

    createBuilder() {
        switch (this.typeValue) {
            case "bar":
                return BarChart.make(this.canvas);
            case "line":
                return LineChart.make(this.canvas);
            case "mixed":
                return MixedChart.make(this.canvas);
            case "percentage":
                return PercentageChart.make(this.canvas);
            case "pie":
                return PieChart.make(this.canvas);
            default:
                throw new Error(`Unsupported chart type: ${this.typeValue}`);
        }
    }

    export() {
        this.chart?.download();
    }
}
