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

        [].slice.call(this.element.querySelectorAll('a[role="tablist"]')).forEach(function (element) {
            let tab = Tab.getOrCreateInstance(element)

            element.addEventListener('click', (event) => {
                event.preventDefault()
                tab.show()
            })
        })

        if (activeId !== null && !this.data.get('active-tab')) {
            Tab.getOrCreateInstance(document.getElementById(activeId)).show();
        }
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

        Tab.getOrCreateInstance(document.getElementById(activeId)).show();

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
