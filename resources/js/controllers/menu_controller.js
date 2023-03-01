import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    /**
     *
     */
    toggle(event) {
        document.body.classList.toggle('menu-open');
        event.preventDefault();
    }
}
