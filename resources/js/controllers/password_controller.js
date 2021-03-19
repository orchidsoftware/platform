import ApplicationController from "./application_controller";

export default class extends ApplicationController {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        'password',
        'iconShow',
        'iconLock'
    ];

    /**
     *
     */
    change() {
        const currentType = this.passwordTarget.type;
        let type = 'password';

        if(currentType === 'text'){
            this.iconLockTarget.classList.add('none');
            this.iconShowTarget.classList.remove('none');
        }

        if (currentType === 'password') {
            type = 'text';
            this.iconLockTarget.classList.remove('none');
            this.iconShowTarget.classList.add('none');
        }

        this.passwordTarget.setAttribute('type', type);
    }
}
