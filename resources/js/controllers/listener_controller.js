import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    listenerEvent = () => this.render();

    /**
     *
     */
    connect() {
        this.addListenerForTargets();
    }

    /**
     *
     */
    addListenerForTargets() {
        this.targets.forEach(name => {
            document.querySelectorAll(`[name="${name}"]`)
                .forEach((field) =>
                    field.addEventListener('change', this.listenerEvent, {
                        once: true
                    })
                );
        });
    }


    render() {
        let params = new FormData();

        this.targets.forEach(name => document.querySelectorAll(`[name="${name}"]`)
            .forEach((field) => {

                if ((field.type === 'checkbox' || field.type === 'radio') && !field.checked) {
                    return;
                }

                if (field.type === "select-multiple") {
                    params.append(name, Array.from(
                        field.querySelectorAll("option:checked")
                    ).map(e => e.value));
                } else {
                    params.append(name, field.value);
                }
            }));

        this.asyncLoadData(params).then(() => {
            document.dispatchEvent(
                new CustomEvent("orchid:listener:after-render", {
                    detail: {
                        params: params,
                    },
                })
            );
        });
    }

    /**
     *
     * @param params
     */
    asyncLoadData(params) {

        if (!this.data.get('async-route')) {
            return;
        }

        return window.axios.post(this.data.get('async-route'), params, {
            headers: {
                'ORCHID-ASYNC-REFERER': window.location.href,
            },
        }).then((response) => {
            this.element.querySelector('[data-async]').innerHTML = response.data;
            this.addListenerForTargets();
        });
    }

    /**
     *
     * @returns {any}
     */
    get targets() {
        return JSON.parse(this.data.get('targets'));
    }
}
