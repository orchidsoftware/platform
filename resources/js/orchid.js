const orchid = {
    register(name, definition) {
        if (!application.router.modulesByIdentifier.has(name)) {
            application.register(name, class extends window.Controller {
                constructor() {
                    super();
                    Object.assign(this, definition);
                }
            });
        }
    }
};

export default orchid;