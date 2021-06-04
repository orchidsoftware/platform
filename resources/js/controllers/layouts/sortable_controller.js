import {Controller} from 'stimulus';

import Sortable from "sortablejs"

export default class extends Controller {

    connect() {
        try{
            const element = this.element.querySelector('tbody')
            this.sortable = Sortable.create(element, {
                handle: '.handle',
                animation: 200
            })
        } catch (error) {
            console.log(error)
        }
    }
}
