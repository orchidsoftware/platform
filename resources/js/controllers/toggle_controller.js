import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static targets = ["button"]

    toggle() {
        this.buttonTarget.click()
    }
}
