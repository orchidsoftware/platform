import ApplicationController from "./application_controller";
import axios from 'axios';

export default class extends ApplicationController {
    /**
     * Initialization & configuration Turbo
     */
    initialize() {
        this.axios();
        this.csrf();

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

        axios.interceptors.request.use(function (config) {
            const url = new URL(config.url);

            if (url.origin !== window.location.origin) {
                delete config.headers['X-CSRF-TOKEN'];
            }
            return config;
        });

        document.addEventListener("turbo:before-fetch-request", (event) => {
            const url = new URL(event.detail.url);

            if (url.origin !== window.location.origin) {
                event.detail.fetchOptions.headers["X-CSRF-TOKEN"] = token.content;
            }
        });

    }

    /**
     *
     */
    goToTop() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    }
}
