import {Controller} from 'stimulus';

export default class extends Controller {


    /**
     *
     */
    initialize() {
        const hiddenColumns = JSON.parse(localStorage.getItem(this.slug));

        this.hiddenColumns = hiddenColumns || [];
    }

    /**
     *
     */
    connect() {
        this.renderColumn();

        $('.dropdown-column-menu').click(function(e) {
            e.stopPropagation();
        });
    }

    /**
     *
     * @param event
     */
    toggleColumn(event) {

        const columnName = event.target.dataset.column;

        this.hiddenColumns.includes(columnName)
            ? this.showColumn(columnName)
            : this.hideColumn(columnName);

        const columns = JSON.stringify(this.hiddenColumns);
        this.renderColumn();
        localStorage.setItem(this.slug, columns);
    }

    /**
     *
     * @param columnName
     */
    showColumn(columnName) {
        this.hiddenColumns = this.hiddenColumns.filter((value) => {
            return value !== columnName;
        });
    }

    /**
     *
     * @param columnName
     */
    hideColumn(columnName) {
        this.hiddenColumns.push(columnName);
    }

    /**
     * Shows or hides columns
     */
    renderColumn() {
        this.element.querySelectorAll('td[data-column], th[data-column]')
            .forEach((column) => {
                column.style.display = '';
            });

        const showClass = this.hiddenColumns.map(
            column => `td[data-column="${column}"], th[data-column="${column}"]`,
        ).join();

        if (showClass.length < 1){
            return;
        }

        this.element.querySelectorAll(showClass)
            .forEach((column) => {
                column.style.display = 'none';
            });

        const checkBoxEnable = this.hiddenColumns.map(
            column => `input[data-column="${column}"]`,
        ).join();

        this.element.querySelectorAll(checkBoxEnable)
            .forEach((checkbox) => {
                checkbox.checked = false;
            });
    }

    /**
     *
     * @returns {string}
     */
    get slug() {
        return this.data.get('slug');
    }
}
