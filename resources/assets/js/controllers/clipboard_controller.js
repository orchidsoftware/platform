import { Controller } from "stimulus"

export default class extends Controller {
    static targets = [ "source" ];

    copy() {
        this.sourceTarget.select();
        document.execCommand("copy");
    }
}