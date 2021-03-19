import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        'index'
    ];

    /**
     *
     */
    connect() {
        this.template = this.element.querySelector('template');
        this.keyValueMode = this.data.get('key-value') === 'true';

        this.detectMaxRows();
    }

    /**
     *
     */
    deleteRow(event) {
        let path = event.path || (event.composedPath && event.composedPath());

        path.forEach((element) => {
            if(element.tagName !== 'TR'){
                return;
            }

            element.parentNode.removeChild(element);
        });

        this.detectMaxRows();
        event.preventDefault();
        return false;
    }

    /**
     *
     */
    addRow(event) {
        this.index++;

        let row = this.template.content.querySelector('tr').cloneNode(true);
        row.innerHTML = row.innerHTML
            .replace(/{index}/gi, this.index);


        let creatingRows = this.element.querySelector('.add-row');

        this.element.querySelector('tbody').insertBefore(row, creatingRows);

        this.detectMaxRows();
        event.preventDefault();
        return false;
    }

    /**
     *
     * @returns {number}
     */
    get index() {
        return parseInt(this.data.get('index'));
    }

    /**
     *
     * @param value
     */
    set index(value) {
        this.data.set('index', value);
    }

    /**
     * Shows or hides the addition
     * of a new line based on line counting
     */
    detectMaxRows() {
        const max = parseInt(this.data.get('rows'));
        if(max === 0){
            return;
        }

        let current = this.element.querySelectorAll('tbody tr:not(.add-row)').length;
        let addRow = this.element.querySelector('.add-row th');
        addRow.style.display = max <= current ? 'none' : '';
    }
}
