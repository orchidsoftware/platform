import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     * Search Event
     *
     * @param event
     */
    query(event) {

        let element = this.getResultElement;

        if (event.target.value === '') {
            element.classList.remove("show")
        }

        axios
            .post(platform.prefix(`/search/${event.target.value}`))
            .then(response => {
                element.classList.add("show");
                element.innerHTML = response.data;
            });
    }

    /**
     * Event for blur
     */
    blur(){
        let element = this.getResultElement;
        element.classList.remove("show")
    }

    /**
     * Event for focus
     *
     * @param event
     */
    focus(event){
        if (event.target.value === '') {
          return;
        }

        let element = this.getResultElement;
        element.classList.add("show")
    }

    /**
     *
     * @returns {HTMLElement}
     */
    get getResultElement(){
        return document.getElementById("search-result");
    }
}
