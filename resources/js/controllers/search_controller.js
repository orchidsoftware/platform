import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static targets = ["query", "result"];

    query(event) {
        const query = event.target.value.trim();

        if (query === "") {
            this.resultTarget.classList.remove("show");
            return;
        }

        this.fetchResults(query);
    }

    blur() {
        setTimeout(() => this.resultTarget.classList.remove("show"), 140);
    }

    focus(event) {
        const query = event.target.value.trim();
        if (query !== "") {
            this.fetchResults(query);
        }
    }

    fetchResults(query) {
        fetch(this.prefix(`/search/${encodeURIComponent(query)}`), {
            method: "POST",
            headers: {
                'X-CSRF-Token': document.head.querySelector('meta[name="csrf_token"]').content,
            },
        })
            .then(response => response.text())
            .then(html => {
                // Check if the input has changed
                if (query !== this.queryTarget.value.trim()) {
                    return;
                }

                this.resultTarget.innerHTML = html;
                this.resultTarget.classList.add("show");
            })
            .catch(() => {
                this.resultTarget.classList.remove("show");
            });
    }
}
