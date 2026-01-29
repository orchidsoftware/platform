import ApplicationController from "./application_controller";
import * as Turbo from "@hotwired/turbo"

export default class extends ApplicationController {

    /**
     *
     * @type {*[]}
     */
    static targets = ["badge"];

    static values = {
        count: {
            type: Number,
            default: 0,
        },
        url: {
            type: String,
        },
        method: {
            type: String,
            default: 'get',
        },
        interval: {
            type: Number,
            default: 60,
        }
    }

    /**
     * Initialize BroadcastChannel and listen for messages from other tabs
     */
    initialize() {
        this.channel = new BroadcastChannel(this.channelName());

        this.channel.onmessage = (event) => {
            const { total } = event.data;
            Turbo.cache.clear();
            this.render(total);
        };
    }

    /**
     * Render initial badge and start periodic updates
     */
    connect() {
        this.channel.postMessage({ total: this.countValue });
        this.updateInterval = this.setUpdateInterval();
    }

    /**
     * Clean up interval and close BroadcastChannel
     */
    disconnect() {
        clearInterval(this.updateInterval);
        this.channel.close();
    }

    /**
     * Returns the name of the BroadcastChannel
     */
    channelName() {
        return 'profile.notifications';
    }

    /**
     * Start periodic requests to fetch notification counts and broadcast updates
     * @returns {number} Interval ID
     */
    setUpdateInterval() {
        const url = this.urlValue;
        const method = this.methodValue;
        const interval = this.intervalValue;

        return setInterval(() => {

            if (!this.ensureLeader()) {
                return;
            }

            axios({ method, url }).then((response) => {
                const total = response.data.total;
                this.channel.postMessage({ total });
                this.render(total);
            });
        }, interval * 1000);
    }


    /**
     * Attempt to become the leader tab if there is no current leader.
     * Updates `isLeader` property accordingly.
     *
     * Note:
     * Due to browser throttling (e.g., Chrome slows down timers on inactive tabs),
     * background tabs may not call this frequently. This is expected behavior
     * and does not indicate a bug in the leader logic.
     */
    ensureLeader() {
        const now = Date.now();
        const leader = JSON.parse(localStorage.getItem('notification_leader') || "null");

        const newLeader = {
            type: 'leader',
            id: this.tabId(),
            expiry: now + this.intervalValue * 2 * 1000, // 2× interval
        };

        if (leader && leader.expiry > now && leader.id !== this.tabId()) {
            return false;
        }

        localStorage.setItem('notification_leader', JSON.stringify(newLeader));

        return true;
    }


    /**
     * Update the badge element with the current notification count
     * @param {number} count
     */
    render(count) {
        let badge =  this.element.querySelector('#notification-circle').innerHTML.trim();

        if (count < 10) {
            badge = count;
        }

        if(count === null || parseInt(count) === 0){
            badge = '';
        }

        this.badgeTarget.classList.remove('d-none');
        this.badgeTarget.innerHTML = badge;
    }
}
