import {Controller} from "stimulus";
import tmpl         from 'blueimp-tmpl';

export default class extends Controller {

    static targets = [
        "column",
        "relation"
    ];

    /**
     *
     */
    connect() {
        console.log('Тест');
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

        let element = this.createTrFromHTML(tmpl("boot-template-column", {
            "field": this.columnTarget.value,
        }));

        document.getElementById('boot-container-column').appendChild(element);
        this.columnTarget.value = '';
        return event.preventDefault();
    }

    /**
     *
     * @param event
     */
    removeColumn(event) {

        event.path.forEach(function (element) {
            if (element.nodeName === 'TR') {
                element.remove();
                return;
            }
        });
    }

    addRelation() {
        alert('test');
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
}