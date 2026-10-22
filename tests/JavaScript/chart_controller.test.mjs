import assert from "node:assert/strict";
import { readFile } from "node:fs/promises";
import test from "node:test";
import vm from "node:vm";
import { JSDOM } from "jsdom";

const source = await readFile(
    new URL(
        "../../resources/js/controllers/chart_controller.js",
        import.meta.url
    ),
    "utf8"
);
const stimulus = await readFile(
    new URL(
        "../../node_modules/@hotwired/stimulus/dist/stimulus.umd.js",
        import.meta.url
    ),
    "utf8"
);
const template = await readFile(
    new URL("../../resources/views/layouts/chart.blade.php", import.meta.url),
    "utf8"
);

function config(type = "line", options = { height: 300, legend: true }) {
    return {
        type,
        options,
        data: {
            labels: ["Mon", "Tue"],
            datasets: [{ name: "Visits", values: [12, 18] }],
        },
    };
}

function attributes(value) {
    const options = { ...value.options };
    if (options.gradient && typeof options.gradient === "object") {
        const { fromOpacity, toOpacity } = options.gradient;
        options.gradient = true;
        if (fromOpacity !== undefined)
            options.gradientFromOpacity = fromOpacity;
        if (toOpacity !== undefined) options.gradientToOpacity = toOpacity;
    }
    return { type: value.type, ...value.data, ...options };
}

function setValue(element, name, value) {
    const attribute = `data-chart-${name.replace(/[A-Z]/g, letter => `-${letter.toLowerCase()}`)}-value`;
    if (value === undefined) element.removeAttribute(attribute);
    else
        element.setAttribute(
            attribute,
            typeof value === "string" ? value : JSON.stringify(value)
        );
}

async function settle() {
    await new Promise(resolve => setTimeout(resolve, 0));
}

async function harness(t, value = config(), readyState = "complete") {
    const dom = new JSDOM("<!doctype html><html><body></body></html>", {
        runScripts: "outside-only",
    });
    const { window } = dom;
    await new Promise(resolve =>
        window.addEventListener("load", resolve, { once: true })
    );
    const state = { readyState };
    const context = dom.getInternalVMContext();
    vm.runInContext(stimulus, context);
    const module = new vm.SourceTextModule(source, { context });
    const builds = [];
    const definitions = [
        "BarChart",
        "LineChart",
        "MixedChart",
        "PercentageChart",
        "PieChart",
    ];
    const exports = definitions.map(type => ({
        make(canvas) {
            const record = {
                type,
                canvas,
                calls: [],
                destroyed: false,
                downloads: 0,
            };
            builds.push(record);
            const builder = {};
            for (const method of [
                "labels",
                "height",
                "colors",
                "gradient",
                "smooth",
                "legend",
                "stacked",
                "maxSlices",
                "tooltip",
                "axes",
                "grid",
                "valueLabels",
                "frameless",
                "dots",
                "line",
                "area",
                "horizontal",
                "width",
                "dotSize",
                "strokeWidth",
                "radius",
                "startAngle",
                "padAngle",
                "dataset",
                "marker",
                "region",
            ]) {
                builder[method] = value => {
                    record.calls.push([method, value]);
                    return builder;
                };
            }
            builder.render = () => ({
                destroy() {
                    record.destroyed = true;
                },
                download() {
                    record.downloads++;
                },
            });
            return builder;
        },
    }));
    await module.link(specifier => {
        if (specifier === "./application_controller") {
            return new vm.SyntheticModule(
                ["default"],
                function () {
                    this.setExport("default", window.Stimulus.Controller);
                },
                { context }
            );
        }
        assert.equal(specifier, "@orchidsoftware/charts");
        return new vm.SyntheticModule(
            definitions,
            function () {
                definitions.forEach((name, index) =>
                    this.setExport(name, exports[index])
                );
            },
            { context }
        );
    });
    await module.evaluate();
    const application = new window.Stimulus.Application();
    await application.start();
    Object.defineProperty(window.document, "readyState", {
        get: () => state.readyState,
    });
    const errors = [];
    window.addEventListener("error", event => {
        errors.push(event.error);
        event.preventDefault();
    });
    application.handleError = error => errors.push(error);
    application.register("chart", module.namespace.default);
    const element = window.document.createElement("div");
    element.dataset.controller = "chart";
    Object.entries(attributes(value)).forEach(([name, item]) =>
        setValue(element, name, item)
    );
    element.dataset.action = template.match(
        /data-action="(load@window[^"]*)"/
    )[1];
    element.innerHTML =
        '<figure data-chart-target="canvas"></figure><a href="#" data-action="chart#export:prevent">Export</a>';
    window.document.body.append(element);
    await settle();
    const controller = application.getControllerForElementAndIdentifier(
        element,
        "chart"
    );
    t.after(async () => {
        element.remove();
        await settle();
        application.stop();
        window.close();
        assert.deepEqual(errors, []);
    });
    return { window, element, controller, builds, state, errors };
}

function calls(build) {
    return JSON.parse(JSON.stringify(build.calls));
}

test("Stimulus creates and releases all five chart types", async t => {
    for (const type of ["line", "bar", "mixed", "pie", "percentage"]) {
        const value = config(type);
        const { element, builds } = await harness(t, value);
        assert.equal(builds.length, 1);
        assert.deepEqual(calls(builds[0]), [
            ["height", 300],
            ["labels", value.data.labels],
            ["legend", true],
            ["dataset", value.data.datasets[0]],
        ]);
        element.remove();
        await settle();
        assert.equal(builds[0].destroyed, true);
    }
});

test("forwards native mixed datasets, gradients, markers and regions", async t => {
    const value = config("mixed", {
        gradient: { fromOpacity: 0.25, toOpacity: 0.02 },
    });
    value.data.datasets = [
        { name: "Actual", chartType: "bar", values: [12, 18] },
        { name: "Plan", chartType: "line", values: [15, 16], smooth: true },
    ];
    value.data.markers = [{ label: "Target", value: 20 }];
    value.data.regions = [{ label: "Range", range: [5, 15] }];
    const { builds } = await harness(t, value);
    assert.deepEqual(calls(builds[0]), [
        ["height", 250],
        ["labels", value.data.labels],
        ["gradient", value.options.gradient],
        ...value.data.datasets.map(dataset => ["dataset", dataset]),
        ["marker", value.data.markers[0]],
        ["region", value.data.regions[0]],
    ]);
});

test("waits for window load using a Stimulus action", async t => {
    const { window, builds, state } = await harness(t, config(), "loading");
    assert.equal(builds.length, 0);
    state.readyState = "complete";
    window.dispatchEvent(new window.Event("load"));
    assert.equal(builds.length, 1);
});

test("disconnect before load releases the action and reconnect renders once", async t => {
    const { window, element, builds, state } = await harness(
        t,
        config(),
        "loading"
    );
    element.remove();
    await settle();
    state.readyState = "complete";
    window.dispatchEvent(new window.Event("load"));
    assert.equal(builds.length, 0);
    window.document.body.append(element);
    await settle();
    assert.equal(builds.length, 1);
});

test("changing a typed height value replaces the chart", async t => {
    const { element, builds } = await harness(t);
    setValue(element, "height", 420);
    await settle();
    assert.equal(builds.length, 2);
    assert.equal(builds[0].destroyed, true);
    assert.deepEqual(
        calls(builds[1]).find(([name]) => name === "height"),
        ["height", 420]
    );
});

test("removing the target releases the chart and typed value changes remain safe", async t => {
    const { element, window, builds, errors } = await harness(t);
    element.querySelector("figure").remove();
    await settle();
    assert.equal(builds[0].destroyed, true);
    setValue(element, "type", "bar");
    await settle();
    assert.deepEqual(errors, []);
    const replacement = window.document.createElement("figure");
    replacement.dataset.chartTarget = "canvas";
    element.append(replacement);
    await settle();
    assert.equal(builds.length, 2);
    assert.equal(builds[1].canvas, replacement);
    assert.equal(builds[1].type, "BarChart");
});

test("replacing the target in one mutation preserves the new chart", async t => {
    const { element, window, builds } = await harness(t);
    const replacement = window.document.createElement("figure");
    replacement.dataset.chartTarget = "canvas";
    element.querySelector("figure").replaceWith(replacement);
    await settle();
    assert.equal(builds.length, 2);
    assert.equal(builds[0].destroyed, true);
    assert.equal(builds[1].destroyed, false);
    assert.equal(builds[1].canvas, replacement);
});

test("removing and restoring data-controller releases and recreates the chart", async t => {
    const { element, builds } = await harness(t);
    element.removeAttribute("data-controller");
    await settle();
    assert.equal(builds[0].destroyed, true);
    element.dataset.controller = "chart";
    await settle();
    assert.equal(builds.length, 2);
});

test("export action prevents navigation and downloads the active chart", async t => {
    assert.match(template, /data-action="chart#export:prevent"/);
    const { element, window, builds } = await harness(t);
    const event = new window.MouseEvent("click", {
        bubbles: true,
        cancelable: true,
    });
    element.querySelector("a").dispatchEvent(event);
    assert.equal(event.defaultPrevented, true);
    assert.equal(builds[0].downloads, 1);
});

test("omitted values use line and height defaults without forcing optional flags", async t => {
    const value = config(undefined, {});
    delete value.type;
    const { builds, controller } = await harness(t, value);
    assert.equal(builds[0].type, "LineChart");
    assert.equal(controller.typeValue, "line");
    assert.equal(controller.heightValue, 250);
    assert.deepEqual(calls(builds[0]), [
        ["height", 250],
        ["labels", value.data.labels],
        ["dataset", value.data.datasets[0]],
    ]);
});

test("missing labels or datasets fails the required data contract", async t => {
    for (const name of ["labels", "datasets"]) {
        const value = config();
        delete value.data[name];
        const { builds, errors } = await harness(t, value);
        assert.equal(builds.length, 0);
        assert.ok(errors.length > 0);
        assert.ok(errors.every(error => error.message.includes(name)));
        errors.length = 0;
    }
});

test("incorrect array transport is rejected by Stimulus before rendering", async t => {
    for (const name of ["labels", "datasets"]) {
        const value = config();
        value.data[name] = { invalid: true };
        const { builds, errors } = await harness(t, value);
        assert.equal(builds.length, 0);
        assert.ok(
            errors.some(error => error.message.toLowerCase().includes("array"))
        );
        errors.length = 0;
    }
});

test("unknown chart types fail instead of silently choosing a builder", async t => {
    const { builds, errors } = await harness(t, config("unknown"));
    assert.equal(builds.length, 0);
    assert.ok(errors.some(error => error.message.includes("unknown")));
    errors.length = 0;
});

test("Stimulus decodes number and boolean values before forwarding native options", async t => {
    const { element, builds, controller } = await harness(
        t,
        config("bar", {
            width: 640,
            legend: false,
            tooltip: false,
            horizontal: true,
            frameless: true,
            dotSize: 4.5,
        })
    );
    assert.equal(controller.widthValue, 640);
    assert.equal(controller.legendValue, false);
    assert.equal(controller.horizontalValue, true);
    const forwarded = Object.fromEntries(calls(builds[0]));
    assert.equal(forwarded.width, 640);
    assert.equal(forwarded.legend, false);
    assert.equal(forwarded.tooltip, false);
    assert.equal(forwarded.horizontal, true);
    assert.equal(forwarded.frameless, true);
    assert.equal(forwarded.dotSize, 4.5);
    element.setAttribute("data-chart-legend-value", "0");
    element.setAttribute("data-chart-width-value", "7_20");
    await settle();
    assert.equal(controller.legendValue, false);
    assert.equal(controller.widthValue, 720);
    assert.equal(Object.fromEntries(calls(builds.at(-1))).width, 720);
});

test("independent labels, datasets and option mutations update the rendered chart", async t => {
    const { element, builds } = await harness(t);
    for (const [name, value, method] of [
        ["labels", ["Wed", "Thu"], "labels"],
        ["datasets", [{ name: "Updated", values: [3, 7] }], "dataset"],
        ["legend", false, "legend"],
        ["colors", ["#123456"], "colors"],
        ["markers", [{ label: "Target", value: 4 }], "marker"],
        ["regions", [{ label: "Range", range: [3, 5] }], "region"],
    ]) {
        const previous = builds.at(-1);
        setValue(element, name, value);
        await settle();
        assert.equal(previous.destroyed, true);
        assert.ok(builds.at(-1) !== previous);
        assert.deepEqual(
            calls(builds.at(-1)).find(([called]) => called === method),
            [
                method,
                ["datasets", "markers", "regions"].includes(name)
                    ? value[0]
                    : value,
            ]
        );
    }
});

test("optional flag removal restores the native builder default", async t => {
    const { element, builds } = await harness(
        t,
        config("line", { frameless: true })
    );
    assert.equal(Object.fromEntries(calls(builds[0])).frameless, true);
    setValue(element, "frameless", undefined);
    await settle();
    assert.ok(!calls(builds.at(-1)).some(([name]) => name === "frameless"));
});

test("gradient uses typed endpoints only when enabled", async t => {
    for (const [options, expected] of [
        [{ gradient: true }, true],
        [{ gradient: { fromOpacity: 0.4 } }, { fromOpacity: 0.4 }],
        [{ gradient: { toOpacity: 0 } }, { toOpacity: 0 }],
        [{ gradient: false, gradientFromOpacity: 0.8 }, false],
    ]) {
        const { builds } = await harness(t, config("line", options));
        assert.deepEqual(
            calls(builds[0]).find(([name]) => name === "gradient"),
            ["gradient", expected]
        );
    }
    const { element, builds } = await harness(
        t,
        config("line", { gradient: true })
    );
    setValue(element, "gradientToOpacity", 0.15);
    await settle();
    assert.deepEqual(
        calls(builds.at(-1)).find(([name]) => name === "gradient"),
        ["gradient", { toOpacity: 0.15 }]
    );
});
