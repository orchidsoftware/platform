window.Turbolinks = require('turbolinks');
Turbolinks.start();

require('./bootstrap');

document.addEventListener('turbolinks:load', function() {
    require('./dashboard');
});


import { Application } from "stimulus";
import { definitionsFromContext } from "stimulus/webpack-helpers";

const application = Application.start();
const context = require.context("./controllers", true, /\.js$/);
application.load(definitionsFromContext(context));
