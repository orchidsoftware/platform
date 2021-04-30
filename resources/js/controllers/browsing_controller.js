import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    /**
     *
     */
    connect() {
        // Selecting the iframe element
        var iframe = this.element.querySelector('iframe');

        // Resize for SPA
        this.resizeTimer = setInterval(() => {
            // Set color background
            iframe.contentDocument.body.style.backgroundColor = 'initial';
            iframe.contentDocument.body.style.overflow = 'hidden';

            let body = iframe.contentWindow.document.body;

            iframe.contentDocument.body.style.height = 'inherit'
            iframe.style.height = Math.max(body.scrollHeight, body.offsetHeight) + 'px';
        }, 100);
    }

    disconnect() {
        clearTimeout(this.resizeTimer);
    }
}
