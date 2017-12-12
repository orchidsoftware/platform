window.dashboard = {

    /**
     *
     * @param path
     * @returns {*}
     */
    prefix: function (path) {

        var prefix = document.head.querySelector('meta[name="dashboard-prefix"]');

        if (prefix && prefix.content.charAt(0) !== '/') {
            prefix = '/' + prefix.content;
        }

        return prefix + path;
    }
};
