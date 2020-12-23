import {Controller} from 'stimulus';

export default class extends Controller {

    static targets = [ "query" ];

    /**
     *
     * @returns {HTMLElement}
     */
    get getResultElement() {
        return document.getElementById('search-result');
    }

    /**
     * Search Event
     *
     * @param event
     */
    query(event) {
        const element = this.getResultElement;
        const startQuery = this.queryTarget.value;

        if (event.target.value === '') {
            element.classList.remove('show');
            return;
        }

        if (event.keyCode === 13) {
            Turbolinks.visit(platform.prefix(`/search/${this.queryTarget.value}`));
        }

        this.showResultQuery(startQuery);
    }

    /**
     * Event for blur
     */
    blur() {
        const element = this.getResultElement;

        setTimeout(() => {
            element.classList.remove('show');
        }, 140);
    }

    /**
     * Event for focus
     *
     * @param event
     */
    focus(event) {
        if (event.target.value === '') {
            return;
        }

        this.showResultQuery(event.target.value);
    }

    /**
     *
     * @param query
     */
    showResultQuery(query) {

        const element = this.getResultElement;

        setTimeout(() => {
            if (query !== this.queryTarget.value) {
                return;
            }

            axios
                .post(platform.prefix(`/search/${query}/compact`))
                .then((response) => {
                    element.classList.add('show');
                    element.innerHTML = response.data;
                });
        }, 200);
    }
}
