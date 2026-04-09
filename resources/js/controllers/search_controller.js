import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static values = {
        failedMessage: {type: String, default: "Search is temporarily unavailable."},
    }

    static targets = ["query", "result", "placeholder"];

    static classes = ["hidden"];

    connect() {
        this.index = -1;
        this.requestId = 0;
    }

    query() {
        const query = this.queryTarget.value.trim();

        if (query === "") {
            this.requestId++;
            this.hidePlaceholder();
            this.resultTarget.innerHTML = "";
            this.resultTarget.classList.add(this.hiddenClass);
            return;
        }

        this.fetchResults(query);
    }

    fetchResults(query) {
        const requestId = ++this.requestId;

        this.showPlaceholder();
        this.resultTarget.classList.add(this.hiddenClass);

        fetch(this.prefix(`/search/${encodeURIComponent(query)}`), {
            method: "POST",
            headers: {
                'X-CSRF-Token': document.head.querySelector('meta[name="csrf_token"]').content,
            },
        })
            .then(response => {
                if (!response.ok) {
                    return Promise.reject(response);
                }

                return response.text();
            })
            .then(html => {
                if (requestId !== this.requestId) {
                    return;
                }

                if (query !== this.queryTarget.value.trim()) {
                    this.hidePlaceholder();
                    this.resultTarget.classList.remove(this.hiddenClass);
                    return;
                }

                this.hidePlaceholder();
                this.resultTarget.innerHTML = html;
                this.resultTarget.classList.remove(this.hiddenClass);
            })
            .catch(() => {
                if (requestId !== this.requestId) {
                    return;
                }

                this.hidePlaceholder();
                this.resultTarget.classList.remove(this.hiddenClass);
                alert(this.failedMessageValue);
            });
    }

    showPlaceholder() {
        if (!this.hasPlaceholderTarget) {
            return;
        }

        this.placeholderTarget.classList.remove(this.hiddenClass);
    }

    hidePlaceholder() {
        if (!this.hasPlaceholderTarget) {
            return;
        }

        this.placeholderTarget.classList.add(this.hiddenClass);
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
