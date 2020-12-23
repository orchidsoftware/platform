import { Controller } from 'stimulus';

export default class extends Controller {
    /**
     *
     */
    connect() {
        const tabs = this.tabs();
        const activeId = tabs[window.location.href][this.data.get('slug')];

        if (activeId !== null) {
            $(`#${activeId}`).tab('show');
        }
    }

    /**
     *
     * @param event
     */
    setActiveTab(event) {
        const activeId = event.target.id;
        const tabs = this.tabs();

        tabs[window.location.href][this.data.get('slug')] = activeId;
        localStorage.setItem('tabs', JSON.stringify(tabs));
        $(`#${activeId}`).tab('show');

        return event.preventDefault();
    }

    /**
     *
     * @returns {any}
     */
    tabs() {
        let tabs = JSON.parse(localStorage.getItem('tabs'));

        if (tabs === null) {
            tabs = {};
        }

        if (tabs[window.location.href] === undefined) {
            tabs[window.location.href] = {};
        }

        if (tabs[window.location.href][this.data.get('slug')] === undefined) {
            tabs[window.location.href][this.data.get('slug')] = null;
        }

        return tabs;
    }
}
