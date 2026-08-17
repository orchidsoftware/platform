import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    /**
     *
     * @type {string[]}
     */
    static targets = ["password", "toggle", "iconShow", "iconLock"];

    /**
     *
     */
    change() {
        const showPassword = this.passwordTarget.type === "password";

        this.passwordTarget.type = showPassword ? "text" : "password";
        this.iconShowTarget.classList.toggle("d-none", showPassword);
        this.iconLockTarget.classList.toggle("d-none", !showPassword);
        this.toggleTarget.ariaLabel = showPassword
            ? this.toggleTarget.dataset.hideLabel
            : this.toggleTarget.dataset.showLabel;
    }
}
