import ApplicationController from "./application_controller";
import { Tab } from 'bootstrap';

export default class extends ApplicationController {
    /**
     *
     */
    connect() {
        const tabs = this.tabs();
        const activeId = tabs[window.location.href][this.data.get('slug')];

        if (activeId !== null && !this.data.get('active-tab')) {
            $(`#${activeId}`).tab('show');
        }


        var triggerTabList = [].slice.call(this.element.querySelectorAll('a[id="button-tab*"]'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new Tab(triggerEl)

            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })

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
