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
        const params = {};

        document.querySelectorAll('[form="filters"]').forEach((element) => {
            if (element.type === 'radio' && element.checked === false) {
                return;
            }

            const name = element.name.trim();
            const value = element.value.trim();

            if (name !== ''
                && value !== null
                && value !== ''
                && value !== undefined) {
                params[name] = value;
            }
        });

        const url = this.buildGetUrlParams(params);

        window.Turbolinks.visit(url, { action: 'replace' });
    }

    /**
     *
     * @param paramsObj
     * @returns {string}
     */
    buildGetUrlParams(paramsObj) {
        let builtUrl = `${window.location.origin + window.location.pathname}?`;
        Object.keys(paramsObj).forEach((key) => {
            builtUrl += `${key}=${paramsObj[key]}&`;
        });
        return builtUrl.substr(0, builtUrl.length - 1);
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
