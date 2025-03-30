const Orchid = {
    /**
     * Registers a controller with the application router.
     * Ensures the controller is always an instance of window.Controller.
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
};

export default Orchid;
