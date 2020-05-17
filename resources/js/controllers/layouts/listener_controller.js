import {Controller} from "stimulus";

export default class extends Controller {

    /**
     *
     */
    connect() {
        this.targets.forEach(name => {
            document.querySelectorAll(`[name="${name}"]`)
                .forEach((field) =>
                    field.addEventListener('change', () => this.render())
                );
        });
    }

    render() {
        let params = {};

        this.targets.forEach(name => document.querySelectorAll(`[name="${name}"]`)
            .forEach((field) => {

                if ((field.type === 'checkbox' || field.type === 'radio') && !field.checked) {
                    return;
                }

                params[name] = field.value;
            }));

        this.asyncLoadData(params);
    }

    /**
     *
     * @param params
     */
    asyncLoadData(params) {

        if (!this.data.get('async')) {
            return;
        }

        let name = this.data.get('url') + '/' + this.data.get('slug') + '/' + this.data.get('method');

        axios.post(name, params).then((response) => {
            this.element.querySelector('[data-async]').innerHTML = response.data;
        });
    }

    /**
     *
     * @returns {any}
     */
    get targets() {
        return JSON.parse(this.data.get('targets'));
    }
}
