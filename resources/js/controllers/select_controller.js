import TomSelect from "tom-select";
import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static targets = ["select"];

    static values = {
        placeholder: { type: String, default: "" },
        allowEmpty: { type: Boolean, default: false },
        messageNotfound: { type: String, default: "No results found" },
        allowCreate: { type: Boolean, default: false },
        messageAdd: { type: String, default: "Add" },
        route: { type: String, default: "" },
        choices: { type: String, default: "" },
        chunk: { type: Number, default: 10 },
    };

    /**
     * Create the TomSelect instance for the wrapped select element.
     */
    connect() {
        this.request = null;
        this.requestId = 0;
        this.select = this.hasSelectTarget
            ? this.selectTarget
            : this.element.querySelector("select");

        this.choices = new TomSelect(this.select, this.options);
    }

    /**
     * Whether options should be loaded from the encrypted choices endpoint.
     *
     * @returns {boolean}
     */
    get isLazy() {
        return Boolean(this.routeValue && this.choicesValue);
    }

    /**
     * TomSelect configuration shared by eager and lazy select fields.
     *
     * @returns {object}
     */
    get options() {
        const options = {
            create: this.allowCreateValue,
            allowEmptyOption: true,
            placeholder: this.placeholder,
            preload: this.isLazy ? "focus" : true,
            plugins: this.plugins,
            maxItems: this.maxItems,
            render: this.renderers,
            onDelete: () => this.allowEmptyValue,
            onItemAdd: function () {
                this.setTextboxValue("");
                this.refreshOptions(false);
            },
        };

        if (!this.isLazy) {
            return options;
        }

        return {
            ...options,
            maxOptions: this.chunkValue,
            valueField: "value",
            labelField: "label",
            searchField: [],
            sortField: [{ field: "$order" }, { field: "$score" }],
            load: (query, callback) => this.loadChoices(query, callback),
        };
    }

    /**
     * Plugins enabled for the current select mode.
     *
     * @returns {string[]}
     */
    get plugins() {
        return this.select.hasAttribute("multiple")
            ? ["change_listener", "remove_button", "clear_button"]
            : ["change_listener"];
    }

    /**
     * Placeholder text resolved from Stimulus values and native attributes.
     *
     * @returns {string}
     */
    get placeholder() {
        if (this.select.getAttribute("placeholder") === "false") {
            return "";
        }

        return (
            this.placeholderValue ||
            this.select.getAttribute("placeholder") ||
            ""
        );
    }

    /**
     * Maximum number of items allowed by TomSelect.
     *
     * @returns {string|number|null}
     */
    get maxItems() {
        return (
            this.select.getAttribute("maximumSelectionLength") ||
            this.select.getAttribute("data-maximum-selection-length") ||
            (this.select.hasAttribute("multiple") ? null : 1)
        );
    }

    /**
     * HTML render callbacks consumed by TomSelect.
     *
     * @returns {object}
     */
    get renderers() {
        return {
            item: (data, escape) => this.renderOption(data, escape),
            option: (data, escape) => this.renderOption(data, escape),
            option_create: (data, escape) =>
                this.renderCreateOption(data, escape),
            no_results: (data, escape) => this.renderNoResults(escape),
        };
    }

    /**
     * Render a selected item or dropdown option.
     *
     * @param {object} data
     * @param {Function} escape
     *
     * @returns {string}
     */
    renderOption(data, escape) {
        return `
            <div>
                ${escape(this.optionLabel(data))}
            </div>
        `.trim();
    }

    /**
     * Render the create-option row when custom values are allowed.
     *
     * @param {object} data
     * @param {Function} escape
     *
     * @returns {string}
     */
    renderCreateOption(data, escape) {
        return `
            <div class="create">
                ${escape(this.messageAddValue)}
                <strong>${escape(data.input)}</strong>&hellip;
            </div>
        `.trim();
    }

    /**
     * Render the empty-search result row.
     *
     * @param {Function} escape
     *
     * @returns {string}
     */
    renderNoResults(escape) {
        return `
            <div class="no-results">
                ${escape(this.messageNotfoundValue)}
            </div>
        `.trim();
    }

    /**
     * Resolve an option label from lazy endpoint and native option shapes.
     *
     * @param {object} data
     *
     * @returns {string}
     */
    optionLabel(data) {
        return data.label ?? data.text ?? data.value ?? "";
    }

    /**
     * Load lazy choices and ignore stale responses from older searches.
     *
     * @param {string} search
     * @param {Function} callback
     */
    loadChoices(search, callback) {
        if (!this.choicesValue) {
            callback([]);

            return;
        }

        this.request?.abort();
        this.request = new AbortController();
        const requestId = ++this.requestId;

        axios
            .post(
                this.routeValue,
                {
                    search,
                    choices: this.choicesValue,
                    chunk: this.chunkValue,
                },
                {
                    signal: this.request.signal,
                }
            )
            .then(response => {
                if (requestId !== this.requestId) {
                    return;
                }

                this.choices.clearOptions();
                callback(Array.isArray(response.data) ? response.data : []);
            })
            .catch(error => {
                if (axios.isCancel?.(error) || error.name === "CanceledError") {
                    return;
                }

                callback([]);
            });
    }

    /**
     * Tear down TomSelect and cancel an active lazy choices request.
     */
    disconnect() {
        this.request?.abort();
        this.choices?.destroy();
    }
}
