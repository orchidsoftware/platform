import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    /**
     *
     */
    connect() {
        if (!('content' in document.createElement('template'))) {
            console.warn('Your browser does not support <template>');
        }

        this.template = this.element.querySelector('#toast');

        this.showAllToasts();
    }

    /**
     *
     * @param title
     * @param message
     * @param type
     */
    alert(title, message, type = 'warning') {
        this.toast(`<b>${title}</b><br> ${message}`, type);
    }

    /**
     *
     * @param message
     * @param type
     */
    toast(message, type = 'warning') {
        const toast = this.template.content.querySelector('.toast').cloneNode(true);

        toast.innerHTML = toast.innerHTML
            .replace(/{message}/, message)
            .replace(/{type}/, type);

        this.element.appendChild(toast);
        this.showAllToasts();
    }

    showAllToasts() {
        $('.toast').on('hidden.bs.toast', (event) => {
            event.target.remove();
        }).toast('show');
    }
}
