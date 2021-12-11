import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        "title"
    ];

    /**
     *
     */
    connect() {

        $(this.element).on('shown.bs.modal', () => {
            let autoFocusElement = this.element.querySelector('[autofocus]');

            if(autoFocusElement !== null){
                autoFocusElement.focus();
            }


            let backdrop = document.querySelector('.modal-backdrop');

            if(backdrop !== null){
                backdrop.id = 'backdrop';
                backdrop.dataset.turboPermanent = true;
            }
        });


        $(this.element).on('hide.bs.modal', () => {
            if (!this.element.classList.contains('fade')) {
                this.element.classList.add('fade', 'in');
            }
        })

        /**
         * The ".invalid-feedback" class has all fields, which contain
         * a textual description of the validation error
         */
        if (this.element.querySelectorAll('.invalid-feedback').length > 0) {
            this.setFormAction(sessionStorage.getItem('last-open-modal'));
            this.element.classList.remove('fade', 'in');
            $(this.element).modal('show');
        }
    }

    /**
     *
     * @param options
     */
    open(options) {
        if (typeof options.title !== "undefined") {
            this.titleTarget.textContent = options.title;
        }

        this.setFormAction(options.submit);

        if (parseInt(this.data.get('async-enable'))) {
            this.asyncLoadData(JSON.parse(options.params));
        }


        $(this.element).modal('toggle');
    }

    /**
     *
     * @param params
     */
    asyncLoadData(params) {
        window.axios.post(this.data.get('async-route'), params, {
            headers: {
                'ORCHID-ASYNC-REFERER': window.location.href,
            },
        }).then((response) => {
            this.element.querySelector('[data-async]').innerHTML = response.data;
        });
    }

    /**
     *
     * @param action
     */
    setFormAction(action) {
        this.element.querySelector('form').action = action;
        sessionStorage.setItem('last-open-modal', action);
    }
}
