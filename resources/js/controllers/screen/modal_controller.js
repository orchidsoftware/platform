import {Controller} from "stimulus";

export default class extends Controller {

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
        if (this.element.querySelectorAll('.is-invalid').length > 0) {
            this.setFormAction(sessionStorage.getItem('last-open-modal'));
            this.element.classList.remove('fade', 'in');
            $(this.element).modal('show');

            $(this.element).on('hide.bs.modal', () => {
                if (!this.element.classList.contains('fade')) {
                    this.element.classList.add('fade', 'in');
                }
            })
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

        if (this.data.get('async')) {
            this.asyncLoadData(JSON.parse(options.params));
        }

        $(this.element).modal('toggle');
    }

    /**
     *
     * @param params
     */
    asyncLoadData(params) {

        let name = this.data.get('url') + '/' + this.data.get('slug') + '/' + this.data.get('method');

        axios.post(name, params).then((response) => {
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
