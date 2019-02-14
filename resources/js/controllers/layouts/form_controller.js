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
            return false;
        }

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
                    Turbolinks.controller.cache.put(url, Turbolinks.Snapshot.wrap(response.data));
                    Turbolinks.visit(url, {action: 'restore'});
                })
                .catch((error) => {
                    console.warn(error);
                });
        });

        return false;
    }


    /**
     *
     * @returns {*}
     */
    validateForm() {

        if (document.getElementById('post-form') === null) {
            return true
        }

        let textValidation = this.element.getAttribute('data-text-validation');

        return window.platform.validateForm('post-form', textValidation);
    }

}
