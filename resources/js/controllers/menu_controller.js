import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static values = {
        collapsed: { type: Boolean, default: false },
        storageKey: { type: String, default: "orchid-aside-collapsed" },
    };

    /**
     * Restores the collapsed state for desktop layouts.
     */
    connect() {
        if (!this.isDesktop()) {
            return;
        }

        try {
            this.collapsedValue =
                localStorage.getItem(this.storageKeyValue) === "1";
        } catch (e) {
            // Ignore unavailable storage.
        }

        this.applyCollapsed();
    }

    /**
     * Mobile: open/close the menu overlay.
     * Desktop: collapse/expand the aside to an icon rail.
     *
     * @param {Event} event
     */
    toggle(event) {
        event.preventDefault();

        if (this.isDesktop()) {
            this.toggleCollapse();
            return;
        }

        document.body.classList.toggle("menu-open");
    }

    /**
     * Collapses or expands the desktop aside.
     *
     * @param {Event|null} event
     */
    toggleCollapse(event = null) {
        if (event) {
            event.preventDefault();
        }

        if (!this.isDesktop()) {
            return;
        }

        this.collapsedValue = !this.collapsedValue;
        this.applyCollapsed();

        try {
            localStorage.setItem(
                this.storageKeyValue,
                this.collapsedValue ? "1" : "0",
            );
        } catch (e) {
            // Ignore unavailable storage.
        }
    }

    /**
     * Applies the collapsed class on the document body.
     */
    applyCollapsed() {
        document.body.classList.toggle("aside-collapsed", this.collapsedValue);
    }

    /**
     * @returns {boolean}
     */
    isDesktop() {
        return window.matchMedia("(min-width: 992px)").matches;
    }
}
