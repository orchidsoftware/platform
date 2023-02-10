import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    /**
     *
     */
    toggle() {
        document.body.classList.toggle('menu-open');
    }
}
