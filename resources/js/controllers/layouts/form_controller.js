import {Controller} from 'stimulus';

export default class extends Controller {


    /**
     * Connect Form
     */
    connect() {
        /**
         * Added focus button for Mac OS firefox/safari
         */
        document.querySelectorAll('button[type=submit]').forEach((button) => {
            button.addEventListener('click', (event) => {
                event.target.focus();
            });
        });
    }

    /**
     *
     */
    submitByForm(event) {
        const formId = this.data.get('id');
        const formElem = document.getElementById(formId);
        formElem.submit();

        event.preventDefault();
        return false;
    }

    /**
     *
     * @param event
     * @returns {boolean}
     */
    submit(event) {

        // disable
        if (this.getActiveElementAttr('data-turbolinks') === 'false') {
            return true;
        }

        if (!this.validateForm(event)) {
            event.preventDefault();
            return false;
        }

        if (this.isSubmit) {
            event.preventDefault();
            return false;
        }

        const action = this.loadFormAction();

        if (action === null) {
            event.preventDefault();
            return false;
        }

        this.isSubmit = true;
        this.animateButton();
        event.preventDefault();

        const screenEventSubmit = new Event('orchid:screen-submit');
        event.target.dispatchEvent(screenEventSubmit);

        const form = new FormData(event.target);

        axios.post(action, form, {
            headers: {
                'X-Requested-With': null,
                Accept: 'text/html,application/xhtml+xml,application/xml',
            },
        })
            .then((response) => {
                const url = response.request.responseURL;
                window.Turbolinks.controller.cache.put(
                    url,
                    Turbolinks.Snapshot.wrap(response.data),
                );
                this.isSubmit = false;
                window.Turbolinks.visit(url, {action: 'restore'});
            })
            .catch((error) => {
                this.isSubmit = false;
                if (error.response) {
                    window.history.pushState({error: error.response.responseURL}, '', error.request.responseURL);
                    Turbolinks.clearCache();
                    const iframe = document.createElement('iframe');
                    iframe.className = 'iframe-error';
                    document.body.appendChild(iframe);
                    iframe.contentWindow.document.write(error.response.data);

                    Array.from(document.body.children).forEach( (element) => {
                        if(element.nodeName != 'IFRAME'){
                            element.style.display = "none";
                        }
                    });


                } else {
                    // eslint-disable-next-line no-console
                    window.platform.alert('Server error', 'The application could not process your request.', 'danger');
                    console.error(`Malformed error ${error}`);
                }
            });

        return false;
    }

    /**
     *
     */
    animateButton() {
        const button = this.data.get('button-animate');
        const text = this.data.get('button-text') || '';

        if (!button || !document.querySelector(button)) {
            return;
        }

        const buttonElement = document.querySelector(button);
        buttonElement.disabled = true;
        buttonElement.classList.add('cursor-wait');
        buttonElement.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
            + `<span class="pl-1">${text}</span>`;
    }

    /**
     * Form validation
     *
     * @returns {boolean}
     */
    validateForm(event) {
        // Cancellation
        if (this.getActiveElementAttr('data-novalidate') === 'true') {
            return true;
        }

        const message = this.data.get('validation');

        if (!event.target.reportValidity()) {
            window.platform.alert('Validation error', message);

            return false;
        }

        return true;
    }

    /**
     * Indicating whether the form is submitted or not.
     *
     * @returns {boolean}
     */
    get isSubmit() {
        return this.data.get('submit') === 'true';
    }

    /**
     *
     * @param attribute
     * @returns {string}
     */
    getActiveElementAttr(attribute) {
        return document.activeElement.getAttribute(attribute);
    }

    /**
     * Sets the status whether the form is submitted or not.
     *
     * @param value
     */
    set isSubmit(value) {
        this.data.set('submit', value);
    }

    /**
     * Returns the action address
     *
     * @returns {string}
     */
    loadFormAction() {
        const formAction = this.element.getAttribute('action');
        const activeElementAction = this.getActiveElementAttr('formaction');

        return activeElementAction || formAction;
    }

    /**
     *
     * @param event
     * @returns {boolean}
     */
    disableKey(event) {

        if (this.element.querySelector('[type=submit]')) {
            return true;
        }

        if (/textarea/i.test(event.target.tagName)) {
            return true;
        }

        if ((event.keyCode || event.which || event.charCode) !== 13) {
            return true;
        }

        event.preventDefault();
        return false;
    }
}
