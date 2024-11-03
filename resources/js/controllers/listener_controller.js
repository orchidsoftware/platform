import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static classes = [ "loading" ]
    static values = {
        url: {
            type: String,
        },
        watched: {
            type: Array,
            default: [],
        },
    }

    /**
     *
     */
    connect() {
        this.watchedValue.forEach(name => {
            document.querySelectorAll(`[name="${name}"]`)
                .forEach((field) =>
                    field.addEventListener('change',  () => this.debouncedHandleFieldChange())
                );
        });
    }

    /**
     * Handles the change event on the target fields by asynchronously loading data.
     */
    handleFieldChange() {
        const formElement = this.element.closest('form');
        formElement.classList.add(...this.loadingClasses);

        const data = new FormData(formElement);

        let state = document.getElementById('screen-state').value;

        // Added state to send
        if (state.length > 0) {
            data.append('_state', state)
        }

        this.loadStream(this.urlValue, data, () => {
            formElement.classList.remove(...this.loadingClasses);
        });
    }

    /**
     * Debounced version of handleFieldChange to prevent multiple rapid requests.
     */
    debouncedHandleFieldChange = this.debounce(() => this.handleFieldChange(), 200);


    /**
     * Utility function to debounce another function.
     *
     * @param {Function} func - The function to debounce.
     * @param {number} wait - The debounce delay in milliseconds.
     * @returns {Function} - A debounced function.
     */
    debounce(func, wait) {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
}
