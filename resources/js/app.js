import * as Turbo from '@hotwired/turbo';
import * as Bootstrap from 'bootstrap';

import { Application } from '@hotwired/stimulus';
import { definitionsFromContext } from '@hotwired/stimulus-webpack-helpers';
import ApplicationController from './controllers/application_controller';

window.Turbo = Turbo;
window.Bootstrap = Bootstrap;
window.application = Application.start();
window.Controller = ApplicationController;

const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));

window.addEventListener('turbo:before-fetch-request', (event) => {
    let state = document.getElementById('screen-state')?.value;

    if (state && state.length > 0) {
        event.detail?.fetchOptions?.body?.append('_state', state);
    }
});

window.registerController = function(name, definition) {
    if (!application.router.modulesByIdentifier.has(name)) {
        application.register(name, class extends window.Controller {
            constructor() {
                super();
                Object.assign(this, definition);
            }
        });
    }
};
