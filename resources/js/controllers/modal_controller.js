import ApplicationController from "./application_controller";
import {Modal} from "bootstrap";

export default class extends ApplicationController {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        "title"
    ];

    initialize() {
        this.show = this.show.bind(this);
        this.hidden = this.hidden.bind(this);
    }

    /**
     *
     */
    connect() {
        if (this.data.get('open')) {
            (new Modal(this.element)).show();
        }

        this.element.addEventListener('shown.bs.modal', this.show);
        this.element.addEventListener('hide.bs.modal', this.hidden);
        this.openLastModal();
    }

    /**
     * Show EventListener
     */
    show(event)
    {
        let autoFocusElement = this.element.querySelector('[autofocus]');

        if(autoFocusElement !== null){
            autoFocusElement.focus();
        }

        let backdrop = document.querySelector('.modal-backdrop');

        if(backdrop !== null){
            backdrop.id = 'backdrop';
            backdrop.dataset.turboTemporary = true;
        }
    }

    /**
     * Hidden EventListener
     */
    hidden(event)
    {
        if (!this.element.classList.contains('fade')) {
            this.element.classList.add('fade', 'in');
        }
        sessionStorage.removeItem('last-open-modal');
    }

    /**
     *
     * @param options
     */
    open(options) {
        options = {... options,
            slug: this.data.get('slug'),
            validateError: this.element.querySelectorAll('.invalid-feedback').length > 0
        };

        this.element.querySelector('form').action = options.submit;

        if (typeof options.title !== "undefined") {
            this.titleTarget.textContent = options.title;
        }

        if (parseInt(this.data.get('async-enable')) && !options.validateError) {
            this.asyncLoadData(JSON.parse(options.params));
        }

        this.lastOpenModal = options;

        (new Modal(this.element)).toggle();
    }

    /**
     * Open last opened modal
     */
    openLastModal() {
        const lastOpenModal = this.lastOpenModal;

        if (this.element.querySelectorAll('.invalid-feedback').length === 0) {
            return;
        }

        if (typeof lastOpenModal === 'object' && lastOpenModal.slug === this.data.get('slug')) {
            this.element.classList.remove('fade', 'in');
            this.open(lastOpenModal)
        }
    }

    /**
     *
     */
    asyncLoadData(params) {
        this.element.classList.add('modal-loading');

        let query = new URLSearchParams(params).toString()

        this.loadStream(`${this.data.get('async-route')}?${query}`, {
            '_state': document.getElementById('screen-state')?.value || null
        })
            .then(() => this.element.classList.remove('modal-loading'));
    }

    set lastOpenModal(options) {
        sessionStorage.setItem('last-open-modal', JSON.stringify(options))
    }

    get lastOpenModal() {
        return JSON.parse(sessionStorage.getItem('last-open-modal')) ?? false
    }
}
