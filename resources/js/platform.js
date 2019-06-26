export default function platform() {
    return {

        /**
         *
         * @param path
         * @returns {*}
         */
        prefix(path) {
            let prefix = document.head.querySelector('meta[name="dashboard-prefix"]');

            if (prefix.content.charAt(0) !== '/') {
                prefix = `/${prefix.content}`;
            }

            return `${location.protocol}//${location.hostname}${location.port ? `:${location.port}` : ''}${prefix.content}${path}`;
        },

        /**
         *
         * @param message
         * @param type
         * @param target
         */
        alert(message, type = 'warning', target = '#dashboard-alerts') {

            if ($(`.alert-${type}`).length !== 0) {
                return;
            }

            $(target).append(
                $('<div/>', {
                    class: `alert alert-${type}`,
                    text: message,
                }).append(
                    $('<button/>', {
                        class: 'close',
                        'data-dismiss': 'alert',
                        'aria-label': 'Close',
                        'aria-hidden': 'true',
                    }).append($('<span/>', {
                        'aria-hidden': 'true',
                        html: '&times;',
                    })),
                ),
            );
        },

        /**
         *
         * @param elem
         */
        formToObject(elem) {
            let output = {};

            new FormData(elem).forEach((value, key) => {

                    if(!Object.prototype.hasOwnProperty.call(output, key)){
                        output[key] = value;
                        return;
                    }

                    let current = output[key];

                    if (!Array.isArray(current)) {
                        current = output[key] = [current];
                    }

                    current.push(value);
                }
            );

            return output;
        },

    };
}
