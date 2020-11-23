import {Controller} from "stimulus"

export default class extends Controller {

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

        $(this.element).modal('show');
    }
}
