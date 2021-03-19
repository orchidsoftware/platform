import ApplicationController from "./application_controller";
import axios from 'axios';
import {Collapse, Dropdown} from 'bootstrap';

export default class extends ApplicationController {
    /**
     *
     */
    initialize() {
        this.axios();
    }

    /**
     *
     */
    connect() {
        this.csrf();
        this.bootstrap();
    }

    /**
     * Initialization & configuration Turbo
     */
    turbo() {
        document.addEventListener('turbo:load', () => {
            this.csrf();
        });
    }

    /**
     * Creating an instance Axios
     */
    axios() {
        window.axios = axios;
    }

    /**
     * We'll load the axios HTTP library which allows us to easily issue requests
     * to our Laravel back-end. This library automatically handles sending the
     * CSRF token as a header based on the value of the "XSRF" token cookie.
     */
    csrf() {
        const token = document.head.querySelector('meta[name="csrf_token"]');

        if (!token) {
            return;
        }

        /**
         * Next we will register the CSRF Token as a common header with Axios so that
         * all outgoing HTTP requests automatically have it attached. This is just
         * a simple convenience so we don't have to attach every token manually.
         */
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }

    /**
     *
     */
    goToTop() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    /**
     *
     */
    bootstrap() {
        let dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        let dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new Dropdown(dropdownToggleEl)
        })

        let collapseElementList = [].slice.call(document.querySelectorAll('.collapse'))
        let collapseList = collapseElementList.map(function (collapseEl) {
            return new Collapse(collapseEl, {
                toggle: false
            })
        })
    }
}
