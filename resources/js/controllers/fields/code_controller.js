import {Controller} from "stimulus";
import CodeFlask from 'codeflask';

export default class extends Controller {

    /**
     *
     */
    connect() {

        console.log(
            this.data.get('language'),
            this.data.get('lineNumbers'),
            this.data.get('defaultTheme')
        );
        
        let input = this.element.querySelector('input');
        
        let language = this.data.get('language');
        if (language=='json') language='js';

        let element = this.element.querySelector('.code');
        const flask = new CodeFlask(element, {
            language: language,
            lineNumbers: this.data.get('lineNumbers'),
            defaultTheme: this.data.get('defaultTheme')
        });

        //flask.updateCode("Hello");
        flask.updateCode($(input).val());
        
        flask.onUpdate((code) => {
            // do something with code here.
            // this will trigger whenever the code
            // in the editor changes.
            //flask.updateCode(flask.getCode());
            console.log(flask.getCode());
            $(input).val(flask.getCode());
        });
    }
}