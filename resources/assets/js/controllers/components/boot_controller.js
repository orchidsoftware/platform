import {Controller} from "stimulus";

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


    addColumn() {
        alert('test');
    }

    addRelation() {
        alert('test');
    }
}