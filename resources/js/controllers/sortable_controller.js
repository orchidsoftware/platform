import ApplicationController from "./application_controller";
import Sortable from "sortablejs";

export default class extends ApplicationController {
    static values = {
        model: String,
        action: String,
        selector: {
            type: String,
            default: ".reorder-handle",
        },
        successMessage: {
            type: String,
            default: "Sorting saved successfully.",
        },
        failureMessage: {
            type: String,
            default: "Failed to save sorting.",
        },
    };

    connect() {
        this.sortable = new Sortable(this.element, {
            animation: 150,
            handle: this.selectorValue,
            onEnd: () => this.reorderElements(),
        });

        this.loadOpenDetails();
    }

    /**
     * Reorder the elements based on the new order
     */
    reorderElements() {
        const params = {
            model: this.modelValue,
            items: [],
        };

        let elements = this.element.querySelectorAll(this.selectorValue);

        elements.forEach((element, index) => {
            params.items.push({
                id: element.getAttribute("data-model-id"),
                sortOrder: index,
            });
        });

        axios
            .post(this.actionValue, params)
            .then(() => this.toast(this.successMessageValue))
            .catch(error => {
                console.error(error);
                this.toast(this.failureMessageValue, "danger");
            });
    }

    toggleDetail(event) {
        const button = event.currentTarget;
        const target = document.getElementById(button.dataset.detailTargetId);
        const row = target?.closest("[data-row-detail-row]");

        if (!target || !row) {
            return;
        }

        const isExpanded = button.getAttribute("aria-expanded") === "true";

        button.setAttribute("aria-expanded", String(!isExpanded));
        row.classList.toggle("d-none", isExpanded);

        if (!isExpanded && button.dataset.detailLoaded !== "true") {
            this.loadDetail(button, target);
        }
    }

    loadOpenDetails() {
        this.element
            .querySelectorAll('[data-detail-loaded="false"][aria-expanded="true"]')
            .forEach(button => {
                const target = document.getElementById(
                    button.dataset.detailTargetId
                );

                if (target) {
                    this.loadDetail(button, target);
                }
            });
    }

    loadDetail(button, target) {
        const body = this.detailData(button.dataset.detailBody);
        const query = this.detailData(button.dataset.detailQuery);
        const queryString = new URLSearchParams(query).toString();
        const url = queryString
            ? `${button.dataset.detailUrl}?${queryString}`
            : button.dataset.detailUrl;

        this.loadStream(url, {
            ...body,
            _state: document.getElementById("screen-state")?.value || null,
        })
            .then(() => {
                button.dataset.detailLoaded = "true";
            })
            .catch(error => {
                console.error(error);
                target.innerHTML = `<div class="text-danger small">${error.message}</div>`;
            });
    }

    detailData(value) {
        if (!value) {
            return {};
        }

        try {
            return JSON.parse(value);
        } catch (error) {
            console.error(error);
            return {};
        }
    }
}
