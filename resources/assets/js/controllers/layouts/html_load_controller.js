import {Controller} from "stimulus";
import Turbolinks from "turbolinks";

export default class extends Controller {

    /**
     *
     */
    initialize() {
        Turbolinks.start();
    }
}