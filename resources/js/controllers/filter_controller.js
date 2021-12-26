import ApplicationController from "./application_controller";
import * as Turbo from "@hotwired/turbo";
import qs from 'qs';

export default class extends ApplicationController {
    static get targets() {
        return ['filterItem'];
    }

    connect() {
        // set focus first element for open dropdown
        this.element.addEventListener('show.bs.dropdown', () => {
            setTimeout(()=> {
                this.element.querySelector('input,textarea,select')?.focus();
            })
        })
    }

    /**
     *
     * @param event
     */
    submit(event) {
        const screenEventSubmit = new Event('orchid:screen-submit');
        event.target.dispatchEvent(screenEventSubmit);

        this.setAllFilter();
        event.preventDefault();
    }

    onFilterClick(event) {
        const currentIndex = this.filterItemTargets.findIndex(target => target.classList.contains('show'));
        const elem = event.currentTarget;
        const index = parseInt(elem.dataset.filterIndex);
        const filterItem = this.filterItemTargets[index];

        if (currentIndex !== -1) {
            // hidden current filter item
            this.filterItemTargets[currentIndex].classList.remove('show');

            if (currentIndex === index) {
                return false;
            }
        }

        // show and position
        filterItem.classList.add('show');
        filterItem.style.top = `${elem.offsetTop}px`;
        filterItem.style.left = `${elem.offsetParent.offsetWidth - 4}px`;
        return false;
    }

    onMenuClick(event) {
        event.stopPropagation();
    }

    /**
     *
     */
    setAllFilter() {
        const formElement = document.getElementById('filters');

        const filters = this.formToObject(formElement);
        filters.sort = this.getUrlParameter('sort');

        const params = qs.stringify(this.removeEmpty(filters), { encode: false, arrayFormat: 'repeat' })

        Turbo.visit(this.getUrl(params), {action: 'replace'});
    }

    /**
     *
     * @param filter
     * @returns {*}
     */
    removeEmpty(filter) {
        Object.keys(filter).forEach((key) => {

            let value = filter[key];

            if(value === null || value === undefined  || value === ''){
                delete filter[key]
            }
        });

        return filter;
    }

    /**
     *
     * @param event
     */
    clear(event) {

        const filters = {
            sort: this.getUrlParameter('sort'),
        };

        const params = qs.stringify(this.removeEmpty(filters), { encode: false, arrayFormat: 'repeat' })

        Turbo.visit(this.getUrl(params), {action: 'replace'});
        event.preventDefault();
    }

    /**
     *
     * @param event
     */
    clearFilter(event) {
        const {filter} = event.currentTarget.dataset;
        document.querySelector(`[name='filter[${filter}]']`).value = '';

        this.element.remove();
        this.setAllFilter();
        event.preventDefault();
    }

    /**
     *
     * @param property
     * @returns {string}
     */
    getUrlParameter(property) {
        const name = property.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        const results = regex.exec(window.location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    /**
     *
     * @param params
     * @returns {string}
     */
    getUrl(params) {
        return `${window.location.origin + window.location.pathname}?${params}`;
    }
}
