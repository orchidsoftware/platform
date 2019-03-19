import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        'password',
        'icon'
    ];

    /**
     *
     */
    change() {
        const currentType = this.passwordTarget.type;
        let type = 'password';
        let icon = 'icon-eye';

        if (currentType === 'password') {
            type = 'text';
            icon = 'icon-lock';
        }

        this.passwordTarget.setAttribute('type', type);
        this.iconTarget.setAttribute('class', icon);
    }
}
