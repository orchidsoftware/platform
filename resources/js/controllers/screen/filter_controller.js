import {Controller} from 'stimulus';

export default class extends Controller {
    /**
     *
     */
    connect() {

    }

    /**
     *
     * @param event
     */
    submit(event) {
        this.setAllFilter();

        event.preventDefault();
    }

    /**
     *
     */
    setAllFilter() {
        let params = {};

        document.querySelectorAll('[form="filters"]').forEach((element) => {

            let name = element.name.trim();
            let value = element.value.trim();

            if (name !== ''
                && value !== null
                && value !== ''
                && value !== undefined) {

                params[name] = value;
            }

        });

        let url = this.buildGetUrlParams(params);

        window.Turbolinks.visit(url, {action: 'replace'});
    }

    /**
     *
     * @param paramsObj
     * @returns {string}
     */
    buildGetUrlParams(paramsObj) {
        let builtUrl = `${window.location.origin + window.location.pathname}?`;
        Object.keys(paramsObj).forEach((key) => {
            builtUrl += `${key}=${paramsObj[key]}&`;
        });
        return builtUrl.substr(0, builtUrl.length - 1);
    }

    /**
     *
     * @param event
     */
    clear(event) {
        window.Turbolinks.visit(window.location.origin + window.location.pathname, {action: 'replace'});
        event.preventDefault();
    }

    /**
     *
     * @param event
     */
    clearFilter(event) {
        let filter = event.target.dataset.filter;
        document.querySelector(`input[name='filter[${filter}]']`).value = '';

        this.element.remove();
        this.setAllFilter();
        event.preventDefault();
    }
}
