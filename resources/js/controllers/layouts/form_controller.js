import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     *
     */
    submitByForm(event) {
        let formId = this.data.get('id');
        let form = this.application.getControllerForElementAndIdentifier(document.getElementById(formId), 'layouts--form');

        form.submit(event);

        event.preventDefault();
        return false;
    }

    /**
     *
     */
    submit(event) {

        if (!this.validateForm()) {
            event.preventDefault();
            return false;
        }

        this.animateButton();
        event.preventDefault();

        setTimeout(() => {
            let formAction = this.element.getAttribute("action");
            let activeElementAction = document.activeElement.getAttribute("formaction");
            let action = activeElementAction || formAction;

            let form = new FormData(event.target);

            axios.post(action, form, {
                headers: {
                    'X-Requested-With': null,
                    'Accept': 'text/html,application/xhtml+xml,application/xml'
                }
            })
                .then((response) => {
                    let url = response.request.responseURL;
                    window.Turbolinks.controller.cache.put(url, Turbolinks.Snapshot.wrap(response.data));
                    window.Turbolinks.visit(url, {action: 'restore'});
                })
                .catch((error) => {
                    window.history.pushState({"html": error.response.data}, "", error.request.responseURL);
                    document.documentElement.innerHTML = error.response.data;
                });
        });

        return false;
    }

    /**
     *
     */
    animateButton(){
        const button = this.data.get('button-animate');
        const text = this.data.get('button-text');

        if(button) {
            const buttonElement = document.querySelector(button);
            buttonElement.disabled = true;
            buttonElement.innerHTML = `<span class="spinner-border spinner-border-sm mb-1" role="status" aria-hidden="true"></span>` +
                `<span class="pl-1">${text || ''}</span>`;
        }
    }

    /**
     *
     * @returns {*}
     */
    validateForm() {

        const formId = this.data.get('id') || this.element.id || document.getElementById('post-form');

        if (formId === null) {
            return true
        }

        let textValidation = this.element.getAttribute('data-text-validation');

        return window.platform.validateForm(formId, textValidation);
    }

}
