import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static targets = ["rows", "row", "template", "empty"];
    static values = { name: String, locked: Boolean, disabled: Boolean };

    connect() {
        this.reindex();
    }

    addRow(event) {
        event.preventDefault();
        if (this.lockedValue) return;

        const row =
            this.templateTarget.content.firstElementChild.cloneNode(true);
        this.rowsTarget.appendChild(row);
        this.changed();
        row.querySelector("input:not([readonly]):not([disabled])")?.focus();
    }

    deleteRow(event) {
        event.preventDefault();
        if (this.lockedValue) return;

        const row = this.findRow(event.target);
        if (!row) return;

        const next = row.nextElementSibling || row.previousElementSibling;
        row.remove();
        this.changed();
        (
            next?.querySelector("input") ||
            this.element.querySelector('[data-action="key-value#addRow"]')
        )?.focus();
    }

    moveUp(event) {
        event.preventDefault();
        if (this.lockedValue) return;

        const row = this.findRow(event.target);
        const previous = row?.previousElementSibling;
        if (previous) {
            previous.before(row);
            this.changed();
            row.querySelector('[data-action="key-value#moveUp"]')?.focus();
        }
    }

    moveDown(event) {
        event.preventDefault();
        if (this.lockedValue) return;

        const row = this.findRow(event.target);
        const next = row?.nextElementSibling;
        if (next) {
            next.after(row);
            this.changed();
            row.querySelector('[data-action="key-value#moveDown"]')?.focus();
        }
    }

    reindex() {
        Array.from(this.rowsTarget.children).forEach((row, index) => {
            row.querySelectorAll("[data-key-value-cell]").forEach(input => {
                input.name = `${this.nameValue}[${index}][${input.dataset.keyValueCell}]`;
            });
        });
        this.emptyTargets.forEach(input => {
            input.disabled =
                this.rowsTarget.children.length > 0 || this.disabledValue;
        });
    }

    changed() {
        this.reindex();
        this.emptyTargets[0].dispatchEvent(
            new Event("change", { bubbles: true })
        );
    }

    findRow(element) {
        const row = element.closest("[data-key-value-row]");
        return row?.parentElement === this.rowsTarget ? row : null;
    }
}
