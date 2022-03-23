import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    /**
     *
     * @param event
     */
    touchstart(event) {
        this.startPageY = event.touches[0].screenY;
    }

    /**
     *
     * @param event
     */
    touchmove(event) {

        if (this.willRefresh) {
            return
        }

        const scrollTop = document.body.scrollTop
        const dy = event.changedTouches[0].screenY - this.startPageY

        if (scrollTop < 1 && dy > 150) {
            this.willRefresh = true;
            this.element.style = 'filter: blur(1px);opacity: 0.2;touch-action: none;';
        }
    }

    /**
     *
     * @param event
     */
    touchend(event) {
        if (this.willRefresh) {
            Turbo.visit(window.location.toString(), {action: 'replace'});
        }
    }
}
