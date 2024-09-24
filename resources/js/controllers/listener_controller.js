import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    /**
     *
     */
    connect() {
        this.targets.forEach(name => {
            document.querySelectorAll(`[name="${name}"]`)
                .forEach((field) =>
                    field.addEventListener('change',  () => this.asyncLoadData())
                );
        });
    }

    /**
     *
     */
    asyncLoadData() {
        const data = new FormData(this.element.closest('form'));


        let state = document.getElementById('screen-state').value;

        // Added state to send
        if (state.length > 0) {
            data.append('_state', state)
        }


        this.loadStream(this.data.get('async-route'), data);
    }

    /**
     *
     * @returns {any}
     */
    get targets() {
        return JSON.parse(this.data.get('targets'));
    }
}
