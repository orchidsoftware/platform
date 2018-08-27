import {Controller} from "stimulus";

export default class extends Controller {

    /**
     *
     */
    connect() {
        let select = this.element.querySelector('select');


        if (select.getAttribute('multiple') === null){
            return;
        }

        setTimeout(() => {
            $(select).select2({
                width: '100%',
                theme: 'bootstrap',
            });
        }, 500);
        
    }
}
