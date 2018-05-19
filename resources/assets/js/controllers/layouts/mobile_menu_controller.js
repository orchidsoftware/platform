import {Controller} from "stimulus";
import Turbolinks from "turbolinks";
import {platform} from "../../platform";

export default class extends Controller {

    /**
     *
     */
    connect() {
        Turbolinks.start();
        window.platform = platform();
    }
}