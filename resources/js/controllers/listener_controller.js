import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    listenerEvent = () => this.submitButton.click();

    /**
     *
     */
    connect() {
        this.addListenerForTargets();

        this.submitButton =  document.createElement('button');
        this.submitButton.classList.add('d-none')
        this.submitButton.type = 'submit';
        this.submitButton.formAction = this.data.get('async-route');
        this.element.appendChild(this.submitButton);
    }

    /**
     *
     */
    addListenerForTargets() {
        this.targets.forEach(name => {
            document.querySelectorAll(`[name="${name}"]`)
                .forEach((field) =>
                    field.addEventListener('change', this.listenerEvent)
                );
        });
    }

    /**
     *
     * @returns {any}
     */
    get targets() {
        return JSON.parse(this.data.get('targets'));
    }
}
