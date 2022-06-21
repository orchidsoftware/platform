import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    listenerEvent = () => this.render();

    /**
     * Mutation Observer for matrix.
     * @type {null|MutationObserver}
     */
    observer = null;

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
        this.observer.disconnect();

        this.targets.forEach(name => {
            document.querySelectorAll(this.selectorFromTarget(name))
                .forEach((field) => {
                        field.addEventListener('change', this.listenerEvent, {
                            once: true
                        });

                        let matrix = field.closest('table.matrix tbody');
                        if(!!matrix) this.addListenerToMatrix(matrix);
                    }
                );
        });
    }

    /**
     *
     * @param {Element} matrix
     */
    addListenerToMatrix(matrix) {
        let options = { attributes: false, childList: true, subtree: false };
        this.observer = new MutationObserver(() => this.addListenerForTargets());
        this.observer.observe(matrix, options);
    }

    /**
     *
     * @param {string} name
     * @return {string}
     */
    selectorFromTarget(name) {
        if (name.includes('*')) {
            return name.split('*').reduce((prev, cur) => prev + `[name*="${cur}"]`, '');
        }
        return `[name="${name}"]`;

    }


    render() {
        let params = new FormData();

        this.targets.forEach(name => document.querySelectorAll(this.selectorFromTarget(name))
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
