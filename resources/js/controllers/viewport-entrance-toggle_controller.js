import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    initialize() {
        this.intersectionObserver = new IntersectionObserver((entries) => this.processIntersectionEntries(entries));
    }

    connect() {
        this.intersectionObserver.observe(this.element);
    }

    disconnect() {
        this.intersectionObserver.unobserve(this.element);
    }

    // Private
    processIntersectionEntries(entries) {
        entries.forEach((entry) => {

            console.log(entry);

            this.element.classList.toggle(this.data.get('class'), entry.isIntersecting);
        });
    }
}
