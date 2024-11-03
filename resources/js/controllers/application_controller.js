import { Controller } from '@hotwired/stimulus';

export default class ApplicationController extends Controller {

    /**
     *
     * @param path
     * @returns {*}
     */
    prefix(path) {
        let prefix = document.head.querySelector('meta[name="dashboard-prefix"]');

        // Remove double slashes from url
        let pathname = `${prefix.content}${path}`.replace(/\/\/+/g, '/')

        return `${location.protocol}//${location.hostname}${location.port ? `:${location.port}` : ''}${pathname}`;
    }

    /**
     *
     * @param title
     * @param message
     * @param type
     */
    alert(title, message, type = 'warning') {
        let toastWrapper = document.querySelector('[data-controller="toast"]');
        let toastController = application.getControllerForElementAndIdentifier(toastWrapper, 'toast');
        toastController.alert(title, message, type);
    }

    /**
     *
     * @param message
     * @param type
     */
    toast(message, type = 'warning') {
        let toastWrapper = document.querySelector('[data-controller="toast"]');
        let toastController = application.getControllerForElementAndIdentifier(toastWrapper, 'toast');
        toastController.toast(message, type);
    }

    /**
     *
     * @param elem
     */
    formToObject(elem) {
        let output = {};

        new FormData(elem).forEach((value, key) => {

                if (!Object.prototype.hasOwnProperty.call(output, key)) {
                    output[key] = value;
                    return;
                }

                let current = output[key];

                if (!Array.isArray(current)) {
                    current = output[key] = [current];
                }

                current.push(value);
            }
        );

        return output;
    }

    /**
     * Loads a Turbo Stream from the given URL with the specified data,
     * and optionally invokes a callback after the main handler.
     *
     * @param {string} url - The endpoint to send the request to.
     * @param {Object} data - The data payload for the request.
     * @param {Function} [callback] - Optional callback to execute after the main handler.
     *
     * @returns {Promise} - A promise that resolves when the stream message is processed.
     */
    loadStream(url, data, callback = null) {
        return window.axios.post(url, data, {
            headers: {
                Accept: "text/vnd.turbo-stream.html",
            },
        })
            .then(response => response.data)
            .then(html => {
                Turbo.renderStreamMessage(html);
                if (typeof callback === 'function') {
                    callback(html);
                }
            });
    }

}
