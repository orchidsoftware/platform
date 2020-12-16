import {Controller} from 'stimulus';
import Turbolinks from 'turbolinks';
import axios from 'axios';

export default class extends Controller {
    /**
     *
     */
    initialize() {
        this.turbo();
        this.axios();
    }

    /**
     *
     */
    connect() {
        this.csrf();
    }

    /**
     * Initialization & configuration Turbolinks
     */
    turbo() {
        if (!Turbolinks.supported) {
            console.warn('Turbo links is not supported');
            return;
        }

        Turbolinks.start();
        Turbolinks.setProgressBarDelay(100);

        document.addEventListener('turbolinks:load', () => {
            this.csrf();
        });
    }

    /**
     * Creating an instance Axios
     */
    axios() {
        window.axios = axios;


        // Add a request interceptor
        window.axios.interceptors.request.use((config) => {
            // Do something before request is sent

            this.startProgressBar();
            return config;
        }, (error) => {

            this.stopProgressBar();
            // Do something with request error
            return Promise.reject(error);
        });

        // Add a response interceptor
        window.axios.interceptors.response.use((response) => {
            // Do something with response data
            this.stopProgressBar();
            return response;
        }, (error) => {
            // Do something with response error
            this.stopProgressBar();
            return Promise.reject(error);
        });
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
    startProgressBar() {
        if (!Turbolinks.supported) {
            return;
        }
        Turbolinks.controller.adapter.progressBar.setValue(0);
        Turbolinks.controller.adapter.progressBar.show();
    }

    /**
     *
     */
    stopProgressBar() {
        if (!Turbolinks.supported) {
            return;
        }
        Turbolinks.controller.adapter.progressBar.hide();
        Turbolinks.controller.adapter.progressBar.setValue(100);
    }
}
