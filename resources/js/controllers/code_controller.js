import { Controller } from 'stimulus';
import CodeFlask from 'codeflask';

export default class extends Controller {
    /**
     *
     */
    connect() {
        const input = this.element.querySelector('input');

        const flask = new CodeFlask(this.element.querySelector('.code'), {
            language: this.data.get('language'),
            lineNumbers: this.data.get('lineNumbers'),
            defaultTheme: this.data.get('defaultTheme'),
            readonly: input.readOnly,
        });

        flask.updateCode(input.value);

        flask.onUpdate((code) => {
            input.value = code;
        });
    }
}
