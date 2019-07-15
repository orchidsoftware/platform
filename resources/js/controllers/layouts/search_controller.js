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

        setTimeout(() => {
            if (startQuery !== this.queryTarget.value) {
                return;
            }

            axios
              .post(platform.prefix(`/search/${event.target.value}`))
              .then((response) => {
                  element.classList.add('show');
                  element.innerHTML = response.data;
              });
        }, 200);
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

        const element = this.getResultElement;

        setTimeout(() => {
            element.classList.add('show');
        }, 240);
    }
}
