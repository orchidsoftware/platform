import ApplicationController from "./application_controller";
import * as Turbo from "@hotwired/turbo"

export default class extends ApplicationController {

    /**
     *
     * @type {*[]}
     */
    static targets = ["badge"];

    /**
     *
     */
    initialize() {
        const count = this.data.get('count');

        localStorage.setItem('profile.notifications', count);

        window.addEventListener('storage', this.storageChanged());
    }

    /**
     *
     */
    connect() {
        this.updateInterval = this.setUpdateInterval();
        this.render();
    }

    /**
     *
     */
    disconnect() {
        clearInterval(this.updateInterval);
        window.removeEventListener('storage', this.storageChanged());
    }

    /**
     *
     * @returns {string}
     */
    storageKey() {
        return 'profile.notifications';
    }

    /**
     *
     * @returns {Function}
     */
    storageChanged() {
        return (event) => {
            if (event.key === this.storageKey()) {
                Turbo.clearCache();
                this.render();
            }
        }
    }

    /**
     *
     * @returns {number}
     */
    setUpdateInterval() {
        const url = this.data.get('url');
        const method = this.data.get('method') || 'get';

        /* Time in seconds */
        const interval = this.data.get('interval') || 60;

         return setInterval(() => {
            axios({method, url}).then((response) => {
                localStorage.setItem('profile.notifications', response.data.total);
                this.render();
            });
        }, interval * 1000);
    }

    /**
     *
     */
    render() {
        const count = localStorage.getItem('profile.notifications');

        let badge =  this.element.querySelector('#notification-circle').innerHTML.trim();

        if (count < 10) {
            badge = count;
        }

        if(count === null || parseInt(count) === 0){
            badge = '';
        }

        this.badgeTarget.innerHTML = badge;
    }
}
