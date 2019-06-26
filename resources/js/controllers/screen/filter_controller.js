import { Controller } from 'stimulus';

export default class extends Controller {
    static get targets() {
        return ['filterItem'];
    }

    /**
     *
     * @param event
     */
    submit(event) {
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

        const filters = window.platform.formToObject(formElement);

        const params = $.param(this.removeEmpty(filters));

        const url = `${window.location.origin + window.location.pathname}?${params}`;

        window.Turbolinks.visit(url, {action: 'replace'});
    }

    /**
     *
     * @param obj
     */
    removeEmpty(obj) {
        return Object.keys(obj)
            .filter(k => obj[k] !== null && obj[k] !== undefined && obj[k] !== '')
            .reduce((newObj, k) =>
                    typeof obj[k] === 'object' ?
                        Object.assign(newObj, {[k]: this.removeEmpty(obj[k])}) :
                        Object.assign(newObj, {[k]: obj[k]}),
                {});
    }

    /**
     *
     * @param event
     */
    clear(event) {
        window.Turbolinks.visit(window.location.origin + window.location.pathname, { action: 'replace' });
        event.preventDefault();
    }

    /**
     *
     * @param event
     */
    clearFilter(event) {
        const { filter } = event.target.dataset;
        document.querySelector(`input[name='filter[${filter}]']`).value = '';

        this.element.remove();
        this.setAllFilter();
        event.preventDefault();
    }
}
