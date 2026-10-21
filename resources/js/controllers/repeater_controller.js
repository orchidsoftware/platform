import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static targets = ["addRow", "rows", "row", "template", "empty"];

    connect() {
        if (this.data.get("readonly") === "true" && this.data.get("disabled") !== "true") {
            this.preserveReadonlyValues();
        }
        this.detectMaxRows();
    }

    preserveReadonlyValues() {
        this.element.querySelectorAll("[data-repeater-mirror]").forEach(input => {
            if (input.closest('[data-controller~="repeater"]') === this.element) input.remove();
        });
        this.rowsTarget.querySelectorAll("input[name], select[name], textarea[name]").forEach(control => {
            if (control.hasAttribute("data-repeater-mirror") || control.disabled || ["file", "submit", "button", "reset"].includes(control.type)) return;
            if (["checkbox", "radio"].includes(control.type) && !control.checked) return;
            const values = control.tagName === "SELECT"
                ? Array.from(control.selectedOptions, option => option.value)
                : [control.value];
            values.forEach(value => {
                const mirror = document.createElement("input");
                mirror.type = "hidden";
                mirror.name = control.name;
                mirror.value = value;
                mirror.setAttribute("data-repeater-mirror", "");
                if (control.hasAttribute("form")) mirror.setAttribute("form", control.getAttribute("form"));
                this.element.appendChild(mirror);
            });
        });
    }

    addRow(event) {
        event.preventDefault();
        if (this.locked || this.atLimit) return;

        this.rowsTarget.appendChild(this.createRow());
        this.changed();
    }

    deleteRow(event) {
        event.preventDefault();
        const row = this.findRow(event.target);
        if (!row || this.locked) return;

        row.remove();
        this.changed();
    }

    cloneRow(event) {
        event.preventDefault();
        const row = this.findRow(event.target);
        if (!row || this.locked || this.atLimit) return;

        const clone = this.createRow();
        const controls = Array.from(row.querySelectorAll("input[name], select[name], textarea[name]"));
        const prefix = `${this.data.get("name")}[`;
        const suffix = name => name.slice(name.indexOf("]", prefix.length) + 1);
        const used = new Map();

        clone.querySelectorAll("input[name], select[name], textarea[name]").forEach(target => {
            const key = suffix(target.name);
            const offset = used.get(key) || 0;
            const source = controls.filter(control => suffix(control.name) === key)[offset];
            used.set(key, offset + 1);
            if (!source || target.type === "file") return;

            if (target.tagName === "SELECT") {
                target.replaceChildren(...Array.from(source.options, option => {
                    const copy = option.cloneNode(true);
                    copy.selected = option.selected;
                    return copy;
                }));
            } else {
                target.value = source.value;
                target.checked = source.checked;
            }
        });

        row.after(clone);
        this.changed();
    }

    moveUp(event) {
        event.preventDefault();
        const row = this.findRow(event.target);
        const previous = row?.previousElementSibling;
        if (!previous || this.locked) return;

        previous.before(row);
        this.changed();
    }

    moveDown(event) {
        event.preventDefault();
        const row = this.findRow(event.target);
        const next = row?.nextElementSibling;
        if (!next || this.locked) return;

        next.after(row);
        this.changed();
    }

    createRow() {
        const row = this.templateTarget.content.firstElementChild.cloneNode(true);
        const index = Number(this.data.get("index")) || 0;
        this.data.set("index", index + 1);
        const placeholder = this.data.get("placeholder");
        this.mapAttributes(row, ["name", "id", "for", "aria-describedby", "aria-labelledby", "data-repeater-name", "data-key-value-name-value"],
            value => value.replaceAll(placeholder, index));
        return row;
    }

    changed() {
        this.rowTargets.forEach((row, index) => this.renameRow(row, index));
        this.detectMaxRows();
        this.emptyTarget.dispatchEvent(new Event("change", { bubbles: true }));
    }

    renameRow(row, index) {
        const prefix = `${this.data.get("name")}[`;
        this.mapAttributes(row, ["name", "data-repeater-name", "data-key-value-name-value"], value => {
            if (!value.startsWith(prefix)) return value;
            const end = value.indexOf("]", prefix.length);
            return `${prefix}${index}${value.slice(end)}`;
        });
    }

    mapAttributes(root, attributes, transform) {
        root.querySelectorAll("*").forEach(element => {
            attributes.forEach(attribute => {
                if (element.hasAttribute(attribute)) {
                    element.setAttribute(attribute, transform(element.getAttribute(attribute)));
                }
            });
            if (element.tagName === "TEMPLATE") this.mapAttributes(element.content, attributes, transform);
        });
    }

    findRow(element) {
        const row = element.closest("[data-repeater-row]");
        return this.rowTargets.includes(row) ? row : null;
    }

    get atLimit() {
        const value = this.data.get("rows");
        return value !== null && value !== "" && this.rowTargets.length >= Number(value);
    }

    get locked() {
        return this.data.get("readonly") === "true" || this.data.get("disabled") === "true";
    }

    detectMaxRows() {
        this.addRowTarget.classList.toggle("d-none", this.locked || this.atLimit);
        this.element.querySelectorAll("[data-repeater-clone]").forEach(button => {
            if (button.closest('[data-controller~="repeater"]') === this.element) {
                button.disabled = this.atLimit;
            }
        });
    }
}
