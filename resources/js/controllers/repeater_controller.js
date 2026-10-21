import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static targets = ["addRow", "rows", "row", "template", "empty"];

    connect() {
        this.reindexRows();
        this.onFormData = event => this.appendReadonlyValues(event);
        document.addEventListener("formdata", this.onFormData);
        this.detectMaxRows();
    }

    disconnect() {
        document.removeEventListener("formdata", this.onFormData);
    }

    appendReadonlyValues(event) {
        if (this.data.get("readonly") !== "true" || this.data.get("disabled") === "true") return;
        if (this.element.parentElement?.closest('[data-controller~="repeater"][data-repeater-readonly="true"]:not([data-repeater-disabled="true"])')) return;

        this.rowsTarget.querySelectorAll("input[name], select[name], textarea[name]").forEach(control => {
            if (!control.name || control.form !== event.target || control.disabled || ["file", "submit", "image", "button", "reset"].includes(control.type)) return;
            if (["checkbox", "radio"].includes(control.type) && !control.checked) return;
            for (let parent = control.parentElement; parent; parent = parent.parentElement) {
                if (parent.tagName !== "FIELDSET" || !parent.disabled || parent.hasAttribute("data-repeater-readonly-fieldset")) continue;
                const legend = Array.from(parent.children).find(child => child.tagName === "LEGEND");
                if (!legend?.contains(control)) return;
            }
            const values = control.tagName === "SELECT"
                ? Array.from(control.selectedOptions).filter(option => !option.disabled && !option.parentElement?.disabled).map(option => option.value)
                : [control.value];
            values.forEach(value => event.formData.append(control.name, value));
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

        this.prepareWidgetClones(row, clone);
        row.after(clone);
        this.changed();
    }

    prepareWidgetClones(source, target) {
        const sources = new Map();
        source.querySelectorAll("[data-controller]").forEach(element => {
            element.getAttribute("data-controller").split(/\s+/).filter(Boolean).forEach(identifier => {
                if (!sources.has(identifier)) sources.set(identifier, []);
                sources.get(identifier).push(element);
            });
        });

        target.querySelectorAll("[data-controller]").forEach(element => {
            element.getAttribute("data-controller").split(/\s+/).filter(Boolean).forEach(identifier => {
                const original = sources.get(identifier)?.shift();
                if (!original) return;
                // Widgets own any state that fresh native controls cannot represent.
                this.application.getControllerForElementAndIdentifier(original, identifier)?.prepareClone?.(element);
            });
        });
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
        this.mapAttributes(row, ["name", "id", "for", "aria-describedby", "aria-labelledby"],
            value => value.replaceAll(placeholder, index));
        return row;
    }

    changed() {
        this.reindexRows();
        this.detectMaxRows();
        this.emptyTarget.dispatchEvent(new Event("change", { bubbles: true }));
    }

    reindexRows() {
        const radios = this.rowTargets.flatMap(row => Array.from(row.querySelectorAll('input[type="radio"]')))
            .filter(control => control.type === "radio")
            .map(control => [control, control.checked]);
        this.rowTargets.forEach((row, index) => this.renameRow(row, index));
        radios.forEach(([control, checked]) => { control.checked = checked; });
    }

    renameRow(row, index) {
        const prefix = `${this.data.get("name")}[`;
        this.mapAttributes(row, ["name"], value => {
            if (!value.startsWith(prefix)) return value;
            const end = value.indexOf("]", prefix.length);
            return `${prefix}${index}${value.slice(end)}`;
        });
    }

    mapAttributes(root, attributes, transform) {
        root.querySelectorAll("*").forEach(element => {
            Array.from(element.attributes).forEach(attribute => {
                const fieldName = /^data-.+-name(?:-value)?$/.test(attribute.name)
                    && attribute.value.startsWith(`${this.data.get("name")}[`);
                if (attributes.includes(attribute.name) || fieldName) {
                    element.setAttribute(attribute.name, transform(attribute.value));
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
