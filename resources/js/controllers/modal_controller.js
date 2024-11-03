import ApplicationController from "./application_controller";
import { Modal } from "bootstrap";

export default class extends ApplicationController {

    static values = {
        slug: {
            type: String,
            default: ''
        },
        url: {
            type: String,
            default: ''
        },
        parameters: {
            type: Object,
        },
        open: {
            type: Boolean,
            default: false
        }
    }

    /**
     * Define targets for elements that this controller interacts with.
     * @type {string[]}
     */
    static targets = [
        "title"
    ];

    // Define a constant for the session storage key
    static SESSION_KEY_FOR_LAST_OPEN_MODAL = 'last-open-modal';

    initialize() {
        // Bind 'this' context to class methods for event handling
        this.show = this.show.bind(this);
        this.hidden = this.hidden.bind(this);
    }

    /**
     * Setup event listeners and initial modal state when the controller connects.
     */
    connect() {
        // Show the modal if the 'open' value is true
        if (this.openValue) {
            (new Modal(this.element)).show();
        }

        // Add event listeners for modal show and hide events
        this.element.addEventListener('shown.bs.modal', this.show);
        this.element.addEventListener('hide.bs.modal', this.hidden);

        // Open the last opened modal if validation errors are present
        this.openLastModal();
    }

    disconnect() {
        // Remove event listeners when the controller disconnects
        this.element.removeEventListener('shown.bs.modal', this.show);
        this.element.removeEventListener('hide.bs.modal', this.hidden);
    }

    /**
     * Handle the modal show event.
     * @param event - The event object for the 'shown.bs.modal' event.
     */
    show(event) {
        // Focus on the element with 'autofocus' attribute, if available
        let autoFocusElement = this.element.querySelector('[autofocus]');

        if (autoFocusElement !== null) {
            autoFocusElement.focus();
        }

        // Modify the backdrop to ensure it's not mistakenly identified as a Turbo frame
        let backdrop = document.querySelector('.modal-backdrop');

        if (backdrop !== null) {
            backdrop.id = 'backdrop';
            backdrop.dataset.turboTemporary = true;
        }
    }

    /**
     * Handle the modal hide event.
     * @param event - The event object for the 'hide.bs.modal' event.
     */
    hidden(event) {
        // Ensure the modal has appropriate classes when hiding
        if (!this.element.classList.contains('fade')) {
            this.element.classList.add('fade', 'in');
        }
        // Clear the stored last open modal from session storage
        this.clearLastOpenModal();
    }

    /**
     * Open the modal with specified options.
     * @param options - Configuration options for opening the modal.
     */
    open(options) {
        options = {
            ...options,
            slug: this.slugValue,
            validateError: this.element.querySelectorAll('.invalid-feedback').length > 0
        };

        // Set the form action URL
        this.element.querySelector('form').action = options.submit;

        // Update the modal title if provided
        if (options.title !== undefined) {
            this.titleTarget.textContent = options.title;
        }

        // Load deferred data if URL is specified and no validation errors are present
        if (Object.keys(this.parametersValue).length !== 0 && !options.validateError) {
            this.asyncLoadData(options.params);
        }

        // Store the last open modal options
        this.storeLastOpenModal(options);

        // Toggle the modal visibility
        (new Modal(this.element)).toggle();
    }

    /**
     * Open the last modal if validation errors are present.
     */
    openLastModal() {
        // If no validation errors are present, do nothing
        if (this.element.querySelectorAll('.invalid-feedback').length === 0) {
            return;
        }

        const lastOpenModal = this.lastOpenModal();

        // Reopen the last modal if it matches the current slug
        if (lastOpenModal && lastOpenModal.slug === this.slugValue) {
            this.element.classList.remove('fade', 'in');
            this.open(lastOpenModal);
        }
    }

    /**
     * Load data asynchronously and update the modal.
     * @param params - Query parameters for the data request.
     */
    asyncLoadData(params) {
        this.element.classList.add('modal-loading');

        // Create query string from parameters
        let query = new URLSearchParams(params).toString();

        // Load data via stream and update modal state
        this.loadStream(`${this.urlValue}?${query}`, {
            '_state': document.getElementById('screen-state')?.value || null,
            ...this.parametersValue
        })
            .then(() => this.element.classList.remove('modal-loading'));
    }

    /**
     * Store the last opened modal options in session storage.
     * @param options - Modal options to store.
     */
    storeLastOpenModal(options) {
        window.sessionStorage.setItem(this.constructor.SESSION_KEY_FOR_LAST_OPEN_MODAL, JSON.stringify(options));
    }

    /**
     * Retrieve the last opened modal options from session storage.
     * @returns {Object|false} - The last opened modal options or false if not found.
     */
    lastOpenModal() {
        return JSON.parse(sessionStorage.getItem(this.constructor.SESSION_KEY_FOR_LAST_OPEN_MODAL)) ?? false;
    }

    /**
     * Clear the last opened modal options from session storage.
     */
    clearLastOpenModal() {
        sessionStorage.removeItem(this.constructor.SESSION_KEY_FOR_LAST_OPEN_MODAL);
    }
}
