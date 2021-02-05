global.$ = global.jQuery = require('jquery');
import * as Turbo from "@hotwired/turbo"
import 'bootstrap';
import { Application, Controller } from 'stimulus';
import { definitionsFromContext } from 'stimulus/webpack-helpers';
import platform from "./platform";

require('select2');

window.platform = platform();
window.application = Application.start();
window.Controller = Controller;

const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));
