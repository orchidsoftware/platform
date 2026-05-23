import ApplicationController from "./application_controller";

/**
 * Stimulus controller for toggling between dark and light themes.
 *
 * Uses the Bootstrap 5.3 color mode mechanism by setting the
 * `data-bs-theme` attribute on the `<html>` element. The user's
 * preference is persisted in `localStorage` under the "theme" key.
 *
 * Icon visibility is handled purely via CSS selectors on
 * `[data-bs-theme]`, so there is no flash during Turbo navigation.
 *
 * @extends ApplicationController
 */
export default class extends ApplicationController {

    /** @type {string} localStorage key used to persist the theme choice. */
    static STORAGE_KEY = "theme";

    /**
     * Called when the controller is connected to the DOM.
     * Applies the resolved theme and subscribes to OS-level changes.
     *
     * @returns {void}
     */
    connect() {
        this.mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
        this.applyTheme(this.resolveTheme());

        this.handleSystemChange = this.handleSystemChange.bind(this);
        this.mediaQuery.addEventListener("change", this.handleSystemChange);
    }

    /**
     * Called when the controller is disconnected from the DOM.
     * Removes the OS-level media query listener.
     *
     * @returns {void}
     */
    disconnect() {
        this.mediaQuery.removeEventListener("change", this.handleSystemChange);
    }

    /**
     * Action: toggles the current theme between "dark" and "light".
     * Persists the new value in `localStorage`.
     *
     * @returns {void}
     */
    toggle() {
        const current = document.documentElement.getAttribute("data-bs-theme");
        const next = current === "dark" ? "light" : "dark";

        localStorage.setItem(this.constructor.STORAGE_KEY, next);
        this.applyTheme(next);
    }

    /**
     * Resolves which theme should be applied.
     * Priority: localStorage -> OS preference -> "light".
     *
     * @returns {"dark"|"light"} The resolved theme name.
     */
    resolveTheme() {
        const stored = localStorage.getItem(this.constructor.STORAGE_KEY);
        if (stored === "dark" || stored === "light") {
            return stored;
        }
        return this.mediaQuery.matches ? "dark" : "light";
    }

    /**
     * Applies the given theme by setting `data-bs-theme` on `<html>`.
     *
     * @param {"dark"|"light"} theme - The theme to apply.
     * @returns {void}
     */
    applyTheme(theme) {
        document.documentElement.setAttribute("data-bs-theme", theme);
    }

    /**
     * Handles OS-level `prefers-color-scheme` changes.
     * Only auto-applies when no explicit user choice is stored.
     *
     * @returns {void}
     */
    handleSystemChange() {
        if (!localStorage.getItem(this.constructor.STORAGE_KEY)) {
            this.applyTheme(this.resolveTheme());
        }
    }
}
