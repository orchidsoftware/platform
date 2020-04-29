export default function platform() {
    return {

        /**
         *
         * @param path
         * @returns {*}
         */
        prefix(path) {
            let prefix = document.head.querySelector('meta[name="dashboard-prefix"]');

            if (prefix.content.charAt(0) !== '/'.charAt(0)) {
                prefix = `/${prefix.content}`;
            } else if (path.charAt(0) === '/'.charAt(0)) {
                path = path.slice(1)
            }

            return `${location.protocol}//${location.hostname}${location.port ? `:${location.port}` : ''}${prefix.content}${path}`;
        },

        /**
         *
         * @param title
         * @param message
         * @param type
         */
        alert(title, message, type = 'warning') {
          let toastWrapper = document.querySelector('[data-controller="layouts--toast"]');
          let toastController = application.getControllerForElementAndIdentifier(toastWrapper, 'layouts--toast');
          toastController.alert(title, message, type);
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
