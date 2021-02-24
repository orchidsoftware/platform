import ApplicationController from "./application_controller"

export default class extends ApplicationController {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        "url",
        "source",
        "medium",
        "campaign",
        "term",
        "content",
    ];

    /**
     *
     */
    connect() {
        if (!this.urlTarget.value) {
            return;
        }

        let url = new URL(this.urlTarget.value);

        this.sourceTarget.value = this.loadParam(url, 'source');
        this.mediumTarget.value = this.loadParam(url, 'medium');
        this.campaignTarget.value = this.loadParam(url, 'campaign');
        this.termTarget.value = this.loadParam(url, 'term');
        this.contentTarget.value = this.loadParam(url, 'content');
    }

    /**
     *
     */
    generate() {
        let url = new URL(this.urlTarget.value);
        this.urlTarget.value = url.protocol + '//' + url.host + url.pathname;

        this.addParams('source', this.sourceTarget.value);
        this.addParams('medium', this.mediumTarget.value);
        this.addParams('campaign', this.campaignTarget.value);
        this.addParams('term', this.termTarget.value);
        this.addParams('content', this.contentTarget.value);
    }

    /**
     *
     * @param text
     * @returns {string}
     */
    slugify(text) {
        return text.toString().toLowerCase().trim()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/&/g, '-and-')         // Replace & with 'and'
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-');        // Replace multiple - with single -
    }

    /**
     *
     * @param replace
     * @param name
     * @param value
     */
    add(replace, name, value) {
        this.urlTarget.value += `${replace + name}=${encodeURIComponent(value)}`;
    }

    /**
     *
     * @param replace
     * @param value
     */
    change(replace, value) {
        this.urlTarget.value = this.urlTarget.value.replace(replace, `$1${encodeURIComponent(value)}`);
    }

    /**
     *
     * @param name
     * @param value
     */
    addParams(name, value) {
        name = `utm_${name}`;
        value = this.slugify(value);

        if (value.trim().length === 0) {
            return;
        }

        let replace = new RegExp("([?&]" + name + "=)[^&]+", "");

        if (this.urlTarget.value.indexOf("?") === -1) {
            this.add("?", name, value);
            return;
        }

        if (replace.test(this.link)) {
            this.change(replace, value);
            return;
        }

        this.add("&", name, value);
    }

    /**
     *
     * @param url
     * @param param
     * @returns {string | null}
     */
    loadParam(url, param) {
        return url.searchParams.get('utm_' + param);
    }

}
