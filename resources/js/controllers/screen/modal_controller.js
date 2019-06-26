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
     * @param options
     */
    open(options) {
        if (typeof options.title !== "undefined") {
            this.titleTarget.textContent = options.title;
        }

        this.element.querySelector('form').action = options.submit;

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

}