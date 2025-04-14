import ApplicationController from "./application_controller";

export default class extends ApplicationController {


    connect() {
        console.log('connected toggle');
    }

    submit(event) {
        const checkbox = event.target;
        const formaction = checkbox.getAttribute('formaction');

        const form = document.getElementById('post-form');

        const button = document.createElement('button');
        button.type = 'submit';

        if (formaction) {
            button.formAction = formaction;
        }

        form.appendChild(button);
        button.click();
        button.remove();
    }
}
