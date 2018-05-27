import { Application } from "stimulus";
import { definitionsFromContext } from "stimulus/webpack-helpers";


require('./bootstrap');

window.application = Application.start();
const context = require.context("./controllers", true, /\.js$/);
application.load(definitionsFromContext(context));