import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     *
     */
    connect() {
        const url = this.data.get('url');
        const method = this.data.get('method') || 'get';

        /* Time in seconds */
        const interval = this.data.get('interval') || 1000;

        setInterval(() => {
            axios({ method, url }).then((response) => {
                this.element.innerHTML = response.data;
            });
        }, interval);
    }
}
