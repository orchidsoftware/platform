import { Application } from "stimulus";
import { definitionsFromContext } from "stimulus/webpack-helpers";

// remove
$.fn.select2.defaults.set('theme', 'bootstrap');


window.application = Application.start();
const context = require.context("./controllers", true, /\.js$/);
application.load(definitionsFromContext(context));