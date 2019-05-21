import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     * Remove cookie && Refresh page
     *
     * @param event
     */
    reset(event) {
        axios.post(platform.prefix('/lock'));
        Turbolinks.clearCache();
        Turbolinks.visit(window.location, { action: 'replace' });
    }
}