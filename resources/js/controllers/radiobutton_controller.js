import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    /**
     *
     */
    checked(event) {
        event.target.offsetParent.querySelectorAll('input').forEach((input) => {
            input.removeAttribute('checked');
        });
        event.target.offsetParent.querySelectorAll('label').forEach((label) => {
            label.classList.remove('active');
        });
        event.target.classList.add('active');
        event.target.setAttribute('checked', 'checked');
        event.target.dispatchEvent(new Event("change"));
    }
}
