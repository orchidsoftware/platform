import { Application, Controller } from 'stimulus';
import { definitionsFromContext } from 'stimulus/webpack-helpers';
import { $, jQuery } from 'jquery';

// remove
$.fn.select2.defaults.set('theme', 'bootstrap');


window.$ = $;
window.jQuery = jQuery;


window.application = Application.start();
window.Controller = Controller;

const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));
