import ApplicationController from "./application_controller";

export default class extends ApplicationController {


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
        if (this.getActiveElementAttr('data-turbo') === 'false') {
            return true;
        }

        if (!this.validateForm(event)) {
            event.preventDefault();
            return false;
        }

        //if (this.isSubmit) {
        //    event.preventDefault();
        //    return false;
        //}

        const action = this.loadFormAction(event);

        if (action === null) {
            event.preventDefault();
            return false;
        }

        //this.isSubmit = true;
        this.animateButton(event);

        const screenEventSubmit = new Event('orchid:screen-submit');
        event.target.dispatchEvent(screenEventSubmit);

        return true;
    }

    /**
     *
     */
    animateButton(event) {
        const button = this.data.get('button-animate') ? document.querySelector(this.data.get('button-animate')) : event.target;
        const text = this.data.get('button-text') || '';

        if (button.tagName !== 'BUTTON') {
            return;
        }

        button.disabled = true;
        button.classList.add('cursor-wait');
        button.innerHTML = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>'
            + `<span class="ps-1">${text}</span>`;
    }

    /**
     * Form validation
     *
     * @returns {boolean}
     */
    validateForm(event) {
        // Cancellation
        if (
            this.getActiveElementAttr('data-novalidate') === 'true'
            || this.getActiveElementAttr('formnovalidate') === 'true'
            || this.getActiveElementAttr('formnovalidate') === 'formnovalidate'
        ) {
            return true;
        }

        const message = this.data.get('validation');

        if (!event.target.reportValidity()) {
            this.alert('Validation error', message);
            event.target.classList.add('was-validated');
            return false;
        }

        event.target.classList.remove('was-validated');

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
    loadFormAction(event) {
        const formAction = this.element.getAttribute('action');
        const activeElementAction = this.getActiveElementAttr('formaction');
        const submitterAction = event.submitter.formAction;

        return activeElementAction || formAction || submitterAction;
    }

    /**
     *
     * @param event
     * @returns {boolean}
     */
    disableKey(event) {

        if (/textarea/i.test(event.target.tagName)) {
            return true;
        }

        if (event.target.isContentEditable) {
            return true;
        }

        if ((event.keyCode || event.which || event.charCode) !== 13) {
            return true;
        }

        event.preventDefault();
        return false;
    }
}
