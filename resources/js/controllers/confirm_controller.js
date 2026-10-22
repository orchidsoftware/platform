import ApplicationController from "./application_controller";
import { Modal } from "bootstrap";

export default class extends ApplicationController {
    /**
     *
     * @type {[string, string]}
     */
    static targets = ["message", "button"];

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
        this.setButton(options.button).setMessage(options.message);

        this.element.addEventListener(
            "hidden.bs.modal",
            () => {
                if (options.trigger?.isConnected) {
                    options.trigger.focus();
                }
            },
            { once: true }
        );

        /**
         * Added focus button for Mac OS firefox/safari
         */
        document.querySelectorAll("button[type=submit]").forEach(button => {
            button.addEventListener("click", event => {
                event.target.focus();
            });
        });

        new Modal(this.element).show(options.trigger);
    }
}
