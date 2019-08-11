export default class extends window.Controller {

    static get targets() {
        return ["name", "output"]
    }

    greet() {
        this.outputTarget.textContent =
            `Hello, ${this.nameTarget.value}!`
    }
}