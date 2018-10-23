import {Controller} from "stimulus";
import tmpl         from 'blueimp-tmpl';

export default class extends Controller {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        "column",
        "relation"
    ];

    /**
     *
     */
    connect() {
        document.querySelector(`#post-form`).addEventListener('change', this.saveModel);
    }

    /**
     *
     * @param event
     * @returns {*}
     */
    addColumn(event) {

        if(event.which !== 13 && event.which !== 1){
            return;
        }

        if (this.columnTarget.value.trim() === '') {
            return;
        }

        if(document.querySelector(`input[name="columns[${this.columnTarget.value}][name]"]`) !== null){
            return;
        }

        let element = this.createTrFromHTML(tmpl("boot-template-column", {
            "field": this.columnTarget.value,
        }));

        document.getElementById('boot-container-column').appendChild(element);
        this.columnTarget.value = '';
        this.saveModel();

        return event.preventDefault();
    }

    /**
     *
     * @param event
     */
    removeColumn(event) {
        event.path.forEach( (element) => {
            if (element.nodeName === 'TR') {
                element.remove();
                return event.preventDefault();
            }
        });
        this.saveModel();
    }

    /**
     *
     */
    addRelation(event) {

        if(event.which !== 13 && event.which !== 1){
            return;
        }

        if (this.relationTarget.value.trim() === '') {
            return;
        }

        if(document.querySelector(`input[name="relations[${this.relationTarget.value}][name]"]`) !== null){
            return;
        }

        let element = this.createTrFromHTML(tmpl("boot-template-relationship", {
            "field": this.relationTarget.value,
        }));

        axios
            .post(platform.prefix(`/boot/${this.relationTarget.value}/getRelated`))
            .then(response => {
                document.querySelector(`select[name="relations[${this.relationTarget.value}][related]"]`).innerHTML = response.data;
            });

        document.getElementById('boot-container-relationship').appendChild(element);
        this.saveModel();

        return event.preventDefault();
    }

    /**
     *
     * @param htmlString
     * @returns {Node | null}
     */
    createTrFromHTML(htmlString) {
        let tr = document.createElement('tr');
        tr.innerHTML = htmlString.trim();

        return tr;
    }

    /**
     * Save model for background
     */
    saveModel() {
        let oData = new FormData(document.querySelector(`#post-form`));

        axios
            .post(window.location.toString() + `/save`, oData);
    }
}