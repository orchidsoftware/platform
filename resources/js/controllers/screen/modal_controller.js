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
        this.titleTarget.textContent = options.title;
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
        axios.post(this.data.get('url') + '/' + this.data.get('method') + '/' + this.data.get('slug'), params).then((response) => {
            this.element.querySelector('[data-async]').innerHTML = response.data;
        });
    }

}