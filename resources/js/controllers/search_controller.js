import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static targets = ["query", "result"];

    connect() {
        this.index = -1;
    }

    query(event) {
        const query = event.target.value.trim();

        if (query === "") {
            return;
        }

        this.fetchResults(query);
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
                this.resultTarget.classList.remove("d-none");
            })
            .catch(() => {
                this.toast("Error fetching search results");
            });
    }


    keydown(event) {
        if (!this.items.length) {
            return;
        }

        switch (event.key) {
            case "ArrowDown":
                event.preventDefault();
                this.move(1);
                break;

            case "ArrowUp":
                event.preventDefault();
                this.move(-1);
                break;

            case "Enter":
                this.open();
                break;
        }
    }

    move(step) {
        this.index += step;

        if (this.index < 0) {
            this.index = this.items.length - 1;
        }

        if (this.index >= this.items.length) {
            this.index = 0;
        }

        this.items[this.index].focus();
    }

    open() {
        const link = this.items[this.index]?.querySelector("a");
        link?.click();
    }

    get items() {
        return Array.from(this.resultTarget.querySelectorAll("[data-search-item]"));
    }
}
