import { Application } from "stimulus";
import { definitionsFromContext } from "stimulus/webpack-helpers";

require('./bootstrap');

document.addEventListener('turbolinks:load', function() {
    require('./dashboard');
});

const application = Application.start();

const context = require.context("./controllers", true, /\.js$/);
application.load(definitionsFromContext(context));