export function platform() {
    return {

        /**
         *
         * @param path
         * @returns {*}
         */
        prefix(path) {
            let prefix = document.head.querySelector('meta[name="dashboard-prefix"]');
            
            if (prefix) {
                if (prefix.content.charAt(0) !== '/') {
                    prefix = `/${prefix.content}`;
                } else if (prefix) {
                    prefix = prefix.content;
                } else {
                    return path;
                }
            }
            return prefix + path;
        },

        /**
         *
         * @param message
         * @param type
         * @param target
         */
        alert(message, type = 'danger', target = '#dashboard-alerts') {
            $(target).append(
                $('<div/>', {
                    class: `alert m-b-none alert-${type}`,
                    text: message,
                }).append(
                    $('<button/>', {
                        class: 'close',
                        'data-dismiss': 'alert',
                        'aria-label': 'Close',
                        'aria-hidden': 'true',
                    }).append($('<span/>', { 'aria-hidden': 'true', html: '&times;' })),
                ),
                $('<div/>', { class: 'clearfix' }),
            );
        },

        /**
         *
         * @param idForm
         * @param message
         * @returns {boolean}
         */
        validateForm(idForm, message) {
            if (!document.getElementById(idForm).checkValidity()) {
                window.platform.alert(message, 'warning b-b');
                return false;
            }
            return true;
        },
    };
}

