const Orchid = {
    /**
     * Registers a controller with the application router.
     * Registers the provided controller definition directly.
     *
     * @param {string} name - The unique name of the controller.
     * @param {Object} definition - The controller definition.
     */
    register(name, definition) {
        if (application.router.modulesByIdentifier.has(name)) {
            console.warn(`Controller with name "${name}" already exists.`);
            return;
        }

        application.register(name, definition);
    },

    /**
     * Returns a unique ID for the current browser tab.
     * The ID stays the same for this tab even after reload.
     * Stored in sessionStorage under "orchid_tab_id".
     *
     * @returns {string}
     */
    id() {
        let tabId = sessionStorage.getItem('orchid_tab_id');

        if (!tabId) {
            tabId = 'orchid_window_' + crypto.randomUUID();
            sessionStorage.setItem('orchid_tab_id', tabId);
        }

        return tabId;
    }
};

export default Orchid;
