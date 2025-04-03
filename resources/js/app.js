import * as Turbo from '@hotwired/turbo';
import * as Bootstrap from 'bootstrap';
import { Application } from '@hotwired/stimulus';
import ApplicationController from './controllers/application_controller';
import Orchid from "./orchid";
import { registerControllers } from 'stimulus-vite-helpers';

window.Turbo = Turbo;
window.Bootstrap = Bootstrap;
window.application = Application.start();
window.Controller = ApplicationController;
window.Orchid = Orchid;

const controllers = import.meta.glob('./**/*_controller.js', { eager: true });
registerControllers(application, controllers);

window.addEventListener('turbo:before-fetch-request', (event) => {
    let state = document.getElementById('screen-state')?.value;

    if (state && state.length > 0) {
        event.detail?.fetchOptions?.body?.append('_state', state);
    }
});
