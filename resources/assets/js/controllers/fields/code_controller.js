import {Controller} from "stimulus";
import CodeFlask from 'codeflask';

export default class extends Controller {

    /**
     *
     */
    connect() {

        console.log(
            this.data.get('language'),
            this.data.get('lineNumbers')
        );


        let element = this.element.querySelector('.code');
        const flask = new CodeFlask(element, {
            language: this.data.get('language'),
            lineNumbers: this.data.get('lineNumbers'),
            defaultTheme: false
        });

        flask.onUpdate((code) => {
            // do something with code here.
            // this will trigger whenever the code
            // in the editor changes.
            console.log(flask.getCode());
        });
    }
}