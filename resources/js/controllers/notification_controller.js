import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    static targets = ["badge"];

    static values = {
        count: { type: Number, default: 0 },
        url: { type: String },
        method: { type: String, default: "get" },
        interval: { type: Number, default: 60 },
        cursor: { type: String, default: "" },
    };

    #pollingTimer = null;
    #intersectionObserver = null;

    connect() {
        this.cursorValue ? this.#initSentinel() : this.#initBadge();
    }

    disconnect() {
        clearInterval(this.#pollingTimer);
        this.#intersectionObserver?.disconnect();
    }

    fetch() {
        this.loadStream(this.prefix("/notifications"));
    }

    // --- Badge (bell icon) mode ---

    render(count) {
        const total = parseInt(count) || 0;
        let content = "";

        if (total >= 10) {
            content = this.element
                .querySelector("#notification-circle")
                .innerHTML.trim();
        } else if (total > 0) {
            content = total;
        }

        this.countValue = total;
        this.badgeTarget.classList.remove("d-none");
        this.badgeTarget.innerHTML = content;
    }

    #initBadge() {
        this.render(this.countValue);
        this.#pollingTimer = setInterval(
            () => this.#pollUnreadCount(),
            this.intervalValue * 1000
        );
    }

    #pollUnreadCount() {
        axios({ method: this.methodValue, url: this.urlValue })
            .then(({ data }) => {
                document.dispatchEvent(
                    new CustomEvent("orchid:notification", {
                        detail: {
                            count: data.total,
                            previousCount: this.countValue,
                        },
                    })
                );
                this.render(data.total);
            })
            .catch(error =>
                console.error("Failed to fetch notifications:", error)
            );
    }

    // --- Sentinel (infinite scroll) mode ---

    #initSentinel() {
        const root = this.element.closest(".modal-body") ?? null;

        this.#intersectionObserver = new IntersectionObserver(
            ([entry]) => this.#onIntersect(entry),
            { root, threshold: 0.1 }
        );

        this.#intersectionObserver.observe(this.element);
    }

    #onIntersect(entry) {
        if (!entry.isIntersecting) return;

        this.#intersectionObserver.disconnect();
        this.loadStream(this.urlValue, { cursor: this.cursorValue });
    }
}
