import ApplicationController from "./application_controller";

export default class extends ApplicationController {
    /**
     *
     */
    initialize() {
        const hiddenColumns = JSON.parse(localStorage.getItem(this.slug));

        this.hiddenColumns = hiddenColumns || [];
    }

    /**
     *
     */
    connect() {
        this.allowDefaultHidden();
        this.renderColumn();

        if (this.element.querySelector(".dropdown-column-menu") !== null) {
            this.element
                .querySelector(".dropdown-column-menu")
                .addEventListener("click", e => {
                    e.stopPropagation();
                });
        }

        this.loadOpenDetails();
    }

    /**
     * Sets default hidden columns
     */
    allowDefaultHidden() {
        if (localStorage.getItem(this.slug) !== null) {
            return;
        }

        this.element
            .querySelectorAll('input[data-default-hidden="true"]')
            .forEach(checkbox => {
                this.hideColumn(checkbox.dataset.column);
            });
    }

    /**
     *
     * @param event
     */
    toggleColumn(event) {
        const columnName = event.target.dataset.column;

        this.hiddenColumns.includes(columnName)
            ? this.showColumn(columnName)
            : this.hideColumn(columnName);

        const columns = JSON.stringify(this.hiddenColumns);
        this.renderColumn();
        localStorage.setItem(this.slug, columns);
    }

    /**
     *
     * @param columnName
     */
    showColumn(columnName) {
        this.hiddenColumns = this.hiddenColumns.filter(value => {
            return value !== columnName;
        });
    }

    /**
     *
     * @param columnName
     */
    hideColumn(columnName) {
        this.hiddenColumns.push(columnName);
    }

    /**
     * Shows or hides columns
     */
    renderColumn() {
        this.element
            .querySelectorAll("td[data-column], th[data-column]")
            .forEach(column => {
                column.style.display = "";
            });

        const showClass = this.hiddenColumns
            .map(
                column =>
                    `td[data-column="${column}"], th[data-column="${column}"]`
            )
            .join();

        if (showClass.length < 1) {
            return;
        }

        this.element.querySelectorAll(showClass).forEach(column => {
            column.style.display = "none";
        });

        const checkBoxEnable = this.hiddenColumns
            .map(column => `input[data-column="${column}"]`)
            .join();

        this.element.querySelectorAll(checkBoxEnable).forEach(checkbox => {
            checkbox.checked = false;
        });
    }

    toggleDetail(event) {
        const button = event.currentTarget;
        const target = document.getElementById(button.dataset.detailTargetId);
        const row = target?.closest("[data-row-detail-row]");

        if (!target || !row) {
            return;
        }

        const isExpanded = button.getAttribute("aria-expanded") === "true";

        button.setAttribute("aria-expanded", String(!isExpanded));
        row.classList.toggle("d-none", isExpanded);

        if (!isExpanded && button.dataset.detailLoaded !== "true") {
            this.loadDetail(button, target);
        }
    }

    loadOpenDetails() {
        this.element
            .querySelectorAll('[data-detail-loaded="false"][aria-expanded="true"]')
            .forEach(button => {
                const target = document.getElementById(
                    button.dataset.detailTargetId
                );

                if (target) {
                    this.loadDetail(button, target);
                }
            });
    }

    loadDetail(button, target) {
        const body = this.detailData(button.dataset.detailBody);
        const query = this.detailData(button.dataset.detailQuery);
        const queryString = new URLSearchParams(query).toString();
        const url = queryString
            ? `${button.dataset.detailUrl}?${queryString}`
            : button.dataset.detailUrl;

        this.loadStream(url, {
            ...body,
            _state: document.getElementById("screen-state")?.value || null,
        })
            .then(() => {
                button.dataset.detailLoaded = "true";
            })
            .catch(error => {
                console.error(error);
                target.innerHTML = `<div class="text-danger small">${error.message}</div>`;
            });
    }

    detailData(value) {
        if (!value) {
            return {};
        }

        try {
            return JSON.parse(value);
        } catch (error) {
            console.error(error);
            return {};
        }
    }

    /**
     *
     * @returns {string}
     */
    get slug() {
        return this.data.get("slug");
    }
}
