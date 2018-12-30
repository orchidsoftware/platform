import { Application, Controller } from 'stimulus';
import { definitionsFromContext } from 'stimulus/webpack-helpers';

global.$ = global.jQuery = require('jquery');

require('popper.js');
require('jquery-ui-bundle');
require('bootstrap');
require('select2');
require('nestable');


window.application = Application.start();
window.Controller = Controller;

const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));
