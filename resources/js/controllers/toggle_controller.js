import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    submit(event) {
        const checkbox = event.target;
        const form = document.getElementById('post-form');

        const button = document.createElement('button');

        for (const { name, value } of checkbox.attributes) {
            button.setAttribute(name, value);
        }

        button.removeAttribute('name');
        button.removeAttribute('value');
        button.type = 'submit';

        form.appendChild(button);
        button.click();
        button.remove();
    }

}
