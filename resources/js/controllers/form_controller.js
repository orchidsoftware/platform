import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static values = {
        needPreventsFormAbandonment: {type: Boolean, default: true},
        hasBeenChanged: {type: Boolean, default: false},
        failedValidationMessage: {type: String, default: "Something went wrong."},
        submitLoadingMessage: {type: String, default: "Loading..."},
        confirmCancelMessage: { type: String, default: "Do you really want to leave? You have unsaved changes." }
    }

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
        // When Turbo disable
        if (this.getActiveElementAttr('data-turbo') === 'false') {
            this.addReserveState(event.target);

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

        const action = this.loadFormAction(event);

        if (action === null) {
            event.preventDefault();
            return false;
        }

        this.isSubmit = true;
        this.animateButton(event);

        this.needPreventsFormAbandonmentValue = false;

        const screenEventSubmit = new Event('orchid:screen-submit');
        event.target.dispatchEvent(screenEventSubmit);

        return true;
    }

    /**
     *
     */
    animateButton(event) {
        const button = event.submitter;

        if (button.tagName !== 'BUTTON') {
            return;
        }

        button.disabled = true;
        button.classList.add('cursor-wait');
        button.classList.add('btn-loading');

        button.innerHTML += '<span class="spinner-loading position-absolute top-50 start-50 translate-middle"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></span>';
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

        if (!event.target.reportValidity()) {
            this.toast(this.failedValidationMessageValue);
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

    /**
     * Trigger for form has been changed
     */
    changed(event) {
        if(this.element === event.target.form) {
            this.hasBeenChangedValue = true;
        }
    }

    /**
     *
     * @param event
     */
    async confirmCancel(event) {
        if (event.type === 'turbo:before-fetch-request') {
            return;
        }

        if (event.target?.activeElement?.type === 'submit') {
            return;
        }

        if (this.needPreventsFormAbandonmentValue === true && this.hasBeenChangedValue === true) {
            event.preventDefault();

            if(event.type === 'beforeunload') {
                event.returnValue = this.confirmCancelMessageValue; //Gecko + IE
                return this.confirmCancelMessageValue; //Gecko + Webkit, Safari, Chrome etc.
            }

            if (window.confirm(this.confirmCancelMessageValue)) {
                event.detail.resume()
            }
        }
    }

    /**
     * Adds or updates a hidden input field with name="_state" and id="reserve_state" in the form.
     * Used in case Turbo is disabled.
     * @param {HTMLFormElement} form - The form to which the field is added
     */
    addReserveState(form) {
        // Get the state value
        const stateValue = this.getState();

        // Find the input element with id 'reserve_state'
        const existingInput = form.querySelector('#reserve_state');

        // If the element already exists, update its value
        if (existingInput) {
            existingInput.value = stateValue;
            return;
        }

        // If the element does not exist, create a new one
        const newInput = document.createElement('input');

        // Set its attributes
        newInput.type = 'hidden';
        newInput.id = 'reserve_state';
        newInput.name = '_state';
        newInput.value = stateValue;

        // Add the new element to the form
        form.appendChild(newInput);
    }

    // Implement this method to return the state value
    getState() {
        return document.getElementById('screen-state')?.value || '';
    }
}
