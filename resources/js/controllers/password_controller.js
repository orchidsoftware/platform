import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    /**
     *
     * @type {string[]}
     */
    static targets = ["password", "iconShow", "iconLock"];

    /**
     *
     */
    change() {
        const currentType = this.passwordTarget.type;
        let type = "password";

        if (currentType === "text") {
            this.iconLockTarget.classList.add("d-none");
            this.iconShowTarget.classList.remove("d-none");
        }

        if (currentType === "password") {
            type = "text";
            this.iconLockTarget.classList.remove("d-none");
            this.iconShowTarget.classList.add("d-none");
        }

        this.passwordTarget.setAttribute("type", type);
    }
}
