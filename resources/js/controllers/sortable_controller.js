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
    }

    disconnect() {
        this.sortable?.destroy();
    }

    moveUp(event) {
        this.moveItem(event, -1);
    }

    moveDown(event) {
        this.moveItem(event, 1);
    }

    moveItem(event, direction) {
        event.preventDefault();

        const item = event.currentTarget.closest("[data-model-id]");
        const sibling =
            direction < 0
                ? item?.previousElementSibling
                : item?.nextElementSibling;

        if (!item || !sibling) {
            return;
        }

        if (direction < 0) {
            this.element.insertBefore(item, sibling);
        } else {
            this.element.insertBefore(sibling, item);
        }

        this.reorderElements();
        event.currentTarget.focus();
    }

    /**
     * Reorder the elements based on the new order
     */
    reorderElements() {
        const params = {
            model: this.modelValue,
            items: [],
        };

        const elements = this.element.querySelectorAll(this.selectorValue);

        elements.forEach((element, index) => {
            params.items.push({
                id: element
                    .closest("[data-model-id]")
                    .getAttribute("data-model-id"),
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
}
