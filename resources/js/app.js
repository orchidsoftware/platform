global.$ = global.jQuery = require('jquery');
import * as Turbo from "@hotwired/turbo"
import 'bootstrap';
import 'select2';
import { Application } from '@hotwired/stimulus';
import { definitionsFromContext } from '@hotwired/stimulus-webpack-helpers';
import ApplicationController from "./controllers/application_controller";

window.application = Application.start();
window.Controller = ApplicationController;

const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));
