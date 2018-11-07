import { Controller } from 'stimulus';

export default class extends Controller {
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

        if (event.target.value === '') {
            element.classList.remove('show');
        }

        axios
            .post(platform.prefix(`/search/${event.target.value}`))
            .then((response) => {
                element.classList.add('show');
                element.innerHTML = response.data;
            });
    }

    /**
     * Event for blur
     */
    blur() {
        const element = this.getResultElement;
        element.classList.remove('show');
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
        element.classList.add('show');
    }
}
