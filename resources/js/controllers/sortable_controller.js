import ApplicationController from "./application_controller"
import Sortable              from 'sortablejs';

export default class extends ApplicationController {

    static values = {
        model:  String,
        action:  String,
        selector: {
            type: String,
            default: '.reorder-handle',
        },
        successMessage: {
            type: String,
            default: 'Sorting saved successfully.',
        },
        failureMessage: {
            type: String,
            default: 'Failed to save sorting.',
        },
    }

    connect() {
        this.sortable = new Sortable(this.element, {
            animation: 150,
            handle: this.selectorValue,
            onEnd: () => this.reorderElements(),
        });
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
                id: element.getAttribute('data-model-id'),
                sortOrder: index,
            })
        });

        axios
            .post(this.actionValue, params)
            .then(() => this.toast(this.successMessageValue))
            .catch((error) => {
                console.error(error);
                this.toast(this.failureMessageValue, 'danger')
            });
    }
}
