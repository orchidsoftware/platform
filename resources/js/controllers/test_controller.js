import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    static values = {
        watched: {
            type: Array,
            default: [],
        },
        url: {
            type: String,
        },
    }

    /**
     *
     */
    connect() {
        this.watchedValue.forEach(name => {
            document.querySelectorAll(`[name="${name}"]`)
                .forEach((field) =>
                    field.addEventListener('change',  () => this.refresh())
                );
        });
    }

    /**
     *
     */
    refresh() {
        const data = new FormData(this.element.closest('form'));

        let state = document.getElementById('screen-state').value;

        // Added state to send
        if (state.length > 0) {
            data.append('_state', state)
        }

        this.loadStream(this.urlValue, data);
    }
}
