import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    /**
     *
     * @type {[string, string]}
     */
    static targets = ["message", "button"]

    /**
     *
     * @param message
     */
    setMessage(message) {
        this.messageTarget.innerHTML = message;

        return this;
    }

    /**
     *
     * @param button
     */
    setButton(button) {
        this.buttonTarget.innerHTML = button;

        return this;
    }

    /**
     *
     */
    open(options) {
        this
            .setButton(options.button)
            .setMessage(options.message);

        /**
         * Added focus button for Mac OS firefox/safari
         */
        document.querySelectorAll('button[type=submit]').forEach((button) => {
            button.addEventListener('click', (event) => {
                event.target.focus();
            });
        });

        $(this.element).modal('show');
    }
}
