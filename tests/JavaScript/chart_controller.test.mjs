// Run with: node --experimental-vm-modules --test tests/JavaScript/chart_controller.test.mjs
import assert from "node:assert/strict";
import { readFile } from "node:fs/promises";
import test from "node:test";
import vm from "node:vm";

const source = await readFile(
    new URL(
        "../../resources/js/controllers/chart_controller.js",
        import.meta.url
    ),
    "utf8"
);

async function harness(readyState = "complete") {
    const listeners = new Map();
    const builds = [];
    const document = { readyState };
    const window = {
        addEventListener(name, handler) {
            listeners.set(name, handler);
        },
        removeEventListener(name, handler) {
            if (listeners.get(name) === handler) listeners.delete(name);
        },
    };
    const context = vm.createContext({ document, window });
    const module = new vm.SourceTextModule(source, { context });
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
                    this.setExport("default", class {});
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
    const controller = new module.namespace.default();
    controller.element = { dataset: {} };
    controller.canvasTarget = { id: "canvas" };
    controller.configValue = {
        type: "line",
        options: {
            height: 300,
            gradient: { fromOpacity: 0.25, toOpacity: 0.02 },
            legend: false,
        },
        data: {
            labels: ["Mon", "Tue"],
            datasets: [{ name: "Visits", values: [12, 18] }],
        },
    };
    return { controller, document, listeners, builds };
}

test("passes the PHP options and native data through for all five chart types", async () => {
    for (const type of ["line", "bar", "mixed", "pie", "percentage"]) {
        const { controller, builds } = await harness();
        const datasets =
            type === "mixed"
                ? [
                      { name: "Actual", chartType: "bar", values: [12, 18] },
                      {
                          name: "Plan",
                          chartType: "line",
                          values: [15, 16],
                          smooth: true,
                          gradient: false,
                      },
                  ]
                : [{ name: "Visits", values: [12, 18] }];
        controller.configValue = {
            type,
            options: { height: 300, legend: false },
            data: { labels: ["Mon", "Tue"], datasets },
        };
        controller.connect();
        assert.equal(builds.length, 1);
        assert.equal(controller.element.dataset.chartType, type);
        assert.deepEqual(builds[0].calls, [
            ["labels", ["Mon", "Tue"]],
            ["height", 300],
            ["legend", false],
            ...datasets.map(dataset => ["dataset", dataset]),
        ]);
        controller.disconnect();
        assert.equal(builds[0].destroyed, true);
    }
});

test("forwards gradient objects, markers and regions without translation", async () => {
    const { controller, builds } = await harness();
    controller.configValue.data.markers = [
        { label: "Target", value: 20, lineStyle: "dashed" },
    ];
    controller.configValue.data.regions = [{ label: "Range", range: [5, 15] }];
    controller.connect();
    assert.deepEqual(
        builds[0].calls.find(([method]) => method === "gradient")[1],
        { fromOpacity: 0.25, toOpacity: 0.02 }
    );
    assert.deepEqual(builds[0].calls.slice(-2), [
        ["marker", controller.configValue.data.markers[0]],
        ["region", controller.configValue.data.regions[0]],
    ]);
});

test("waits for stylesheets and cancels pending rendering on disconnect", async () => {
    const { controller, document, listeners, builds } =
        await harness("loading");
    controller.connect();
    assert.equal(builds.length, 0);
    assert.equal(listeners.has("load"), true);
    controller.disconnect();
    assert.equal(listeners.has("load"), false);
    document.readyState = "complete";
    controller.connect();
    assert.equal(builds.length, 1);
});

test("renders on window load", async () => {
    const { controller, listeners, builds } = await harness("loading");
    controller.connect();
    listeners.get("load")();
    assert.equal(builds.length, 1);
});

test("replaces the chart when options or the canvas target change", async () => {
    const { controller, builds } = await harness();
    controller.configValueChanged();
    controller.canvasTargetConnected();
    assert.equal(builds.length, 0);
    controller.connect();
    controller.configValue.options.height = 420;
    controller.configValueChanged();
    assert.equal(builds[0].destroyed, true);
    assert.deepEqual(
        builds[1].calls.find(([method]) => method === "height"),
        ["height", 420]
    );
    controller.canvasTarget = { id: "replacement" };
    controller.canvasTargetConnected();
    assert.equal(builds[1].destroyed, true);
    assert.equal(builds[2].canvas.id, "replacement");
    controller.disconnect();
    controller.configValueChanged();
    assert.equal(builds.length, 3);
    assert.equal(builds[2].destroyed, true);
});

test("exports the current instance and prevents link navigation", async () => {
    const { controller, builds } = await harness();
    controller.connect();
    let prevented = false;
    controller.export({
        preventDefault() {
            prevented = true;
        },
    });
    assert.equal(prevented, true);
    assert.equal(builds[0].downloads, 1);
});
