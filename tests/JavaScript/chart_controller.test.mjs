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
    application.handleError = error => errors.push(error);
    application.register("chart", module.namespace.default);
    const element = window.document.createElement("div");
    element.dataset.controller = "chart";
    element.dataset.chartConfigValue = JSON.stringify(value);
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
        assert.equal(element.dataset.chartType, type);
        assert.deepEqual(calls(builds[0]), [
            ["labels", value.data.labels],
            ["height", 300],
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

test("changing the config attribute replaces the chart", async t => {
    const { element, builds } = await harness(t);
    element.dataset.chartConfigValue = JSON.stringify(
        config("bar", { height: 420 })
    );
    await settle();
    assert.equal(builds.length, 2);
    assert.equal(builds[0].destroyed, true);
    assert.deepEqual(
        calls(builds[1]).find(([name]) => name === "height"),
        ["height", 420]
    );
});

test("removing the target releases the chart and config changes remain safe", async t => {
    const { element, window, builds, errors } = await harness(t);
    element.querySelector("figure").remove();
    await settle();
    assert.equal(builds[0].destroyed, true);
    element.dataset.chartConfigValue = JSON.stringify(config("bar"));
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
