import ApplicationController from "./application_controller";
import { Tab } from 'bootstrap';

export default class extends ApplicationController {
    /**
     *
     */
    connect() {
        const tabs = this.tabs();
        const location = window.location.href.split(/[?#]/)[0];
        const activeId = tabs[location][this.data.get('slug')];

        if (activeId !== null && !this.data.get('active-tab')) {
            (new Tab(document.getElementById(activeId))).show();
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
        const location = window.location.href.split(/[?#]/)[0];

        tabs[location][this.data.get('slug')] = activeId;
        localStorage.setItem('tabs', JSON.stringify(tabs));

        (new Tab(document.getElementById(activeId))).show();

        return event.preventDefault();
    }

    /**
     *
     * @returns {any}
     */
    tabs() {
        let tabs = JSON.parse(localStorage.getItem('tabs'));
        const location = window.location.href.split(/[?#]/)[0];

        if (tabs === null) {
            tabs = {};
        }

        if (tabs[location] === undefined) {
            tabs[location] = {};
        }

        if (tabs[location][this.data.get('slug')] === undefined) {
            tabs[location][this.data.get('slug')] = null;
        }

        return tabs;
    }
}
