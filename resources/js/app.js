global.$ = global.jQuery = require('jquery');
import * as Turbo from "@hotwired/turbo"
import 'bootstrap';
import 'select2';
import { Application, Controller } from 'stimulus';
import { definitionsFromContext } from 'stimulus/webpack-helpers';
import platform from "./platform";


window.platform = platform();
window.application = Application.start();
window.Controller = Controller;

const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));
