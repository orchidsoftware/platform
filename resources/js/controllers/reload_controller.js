import ApplicationController from "./application_controller";

export default class extends ApplicationController {

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
