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
