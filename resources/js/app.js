import * as Turbo from '@hotwired/turbo';
import * as Bootstrap from 'bootstrap';

import { Application } from '@hotwired/stimulus';
import { registerControllers } from 'stimulus-vite-helpers'
import ApplicationController from './controllers/application_controller';

window.Turbo = Turbo;
window.Bootstrap = Bootstrap;
window.application = Application.start();
window.Controller = ApplicationController;

const controllers = import.meta.glob('./**/*_controller.js',{eager: true})
registerControllers(application, controllers)
