import {Controller} from "stimulus"

export default class extends Controller {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        "id",
        "label",
        "slug",
        "auth",
        "robot",
        "style",
        "target",
        "title",
    ];

    /**
     *
     */
    connect() {

        let menu = this;

        $('.dd').nestable({})
            .on('change', () => {
                menu.sort();

                menu.send();
            }).on('click', '.edit', (event) => {
            menu.edit(event.target);
        });

        menu.sort();

        this.checkExist();
    }

    /**
     *
     * @param object
     */
    load(object) {
        this.id = object.id;
        this.labelTarget.value = object.label;
        this.slugTarget.value = object.slug;
        this.authTarget.value = object.auth;
        this.robotTarget.value = object.robot;
        this.styleTarget.value = object.style;
        this.targetTarget.value = object.target;
        this.titleTarget.value = object.title;


        this.checkExist();
    }

    /**
     *
     */
    sort() {
        $('.dd-item').each((i, item) => {
            $(item).data({
                sort: i,
            });
        });
    }

    /**
     *
     * @param element
     */
    edit(element) {
        let data = $(element)
            .parent()
            .data();

        data.label = $(element)
            .prev()
            .text();
        this.load(data);
    }

    /**
     *
     * @returns {{label: *, title: *, auth: *, slug: *, robot: *, style: *, target: *}}
     */
    getFormData() {
        return {
            label: this.labelTarget.value,
            title: this.titleTarget.value,
            auth: this.authTarget.value,
            slug: this.slugTarget.value,
            robot: this.robotTarget.value,
            style: this.styleTarget.value,
            target: this.targetTarget.value,
        }
    }

    /**
     *
     */
    add() {
        if (!this.checkForm()) {
            return;
        }

        let $menu = this, $dd = $('.dd'),
            data              = {
                menu: $dd.attr('data-name'),
                lang: $dd.attr('data-lang'),
                data: this.getFormData()
            };

        axios
            .get(this.getUri('create/'), {params: data})
            .then((response) => {
                $menu.add2Dom(response.data.id)
            });
    }

    /**
     *
     * @param id
     */
    add2Dom(id) {
        $('.dd > .dd-list').append(
            `<li class="dd-item dd3-item" data-id="${id}"> <div  class="dd-handle dd3-handle">Drag</div><div  class="dd3-content">${this.labelTarget.value}</div> <div  class="edit icon-pencil"></div></li>`,
        );

        $(`li[data-id=${id}]`).data(this.getFormData());

        this.sort();
        this.clear();
        this.send();
    }

    /**
     *
     */
    save() {
        if (!this.checkForm()) {
            return;
        }

        $(`li[data-id=${this.id}]`).data(this.getFormData());
        $(`li[data-id=${this.id}] > .dd3-content`).html(this.labelTarget.value);

        this.clear();
        this.send();
    }

    /**
     *
     * @param id
     */
    destroy(id) {
        axios
            .delete(this.getUri(id))
            .then(response => {
            });
    }

    /**
     *
     */
    remove() {
        $(`li[data-id=${this.id}]`).remove();
        this.destroy(this.id);
        this.clear();
    }

    /**
     *
     */
    clear() {
        this.labelTarget.value = '';
        this.titleTarget.value = '';
        this.authTarget.value = 0;
        this.slugTarget.value = '';
        this.robotTarget.value = 'follow';
        this.styleTarget.value = '';
        this.targetTarget.value = '_self';
        this.id = '';


        this.checkExist();
        window.Turbolinks.visit(window.location, {action: 'replace'});
    }

    /**
     *
     */
    send() {
        let $dd  = $('.dd'),
            name = $dd.attr('data-name'),
            data = {
                lang: $dd.attr('data-lang'),
                data: $dd.nestable('serialize'),
            };

        axios
            .put(this.getUri(name), data)
            .then(response => {
            });
    }

    /**
     *
     * @returns {boolean}
     */
    checkForm() {
        if (!this.labelTarget.value) {
            this.showBlocks('errors.label');
            return false;
        }

        if (!this.titleTarget.value) {
            this.showBlocks('errors.title');
            return false;
        }

        if (!this.slugTarget.value) {
            this.showBlocks('errors.slug');
            return false;
        }


        this.hiddenBlocks([
            'errors.slug',
            'errors.label',
            'errors.title',
        ]);

        return true;
    }

    /**
     *
     */
    checkExist() {
        if (this.exist()) {

            this.showBlocks([
                'menu.remove',
                'menu.reset',
                'menu.save'
            ]);

            this.hiddenBlocks('menu.create');
            return;
        }


        this.showBlocks([
            'menu.create',
        ]);

        this.hiddenBlocks([
            'menu.remove',
            'menu.reset',
            'menu.save'
        ]);
    }

    /**
     *
     * @returns {boolean}
     */
    exist() {
        return Number.isInteger(this.id) &&
            $(`li[data-id=${this.id}]`).length > 0;
    }

    /**
     *
     * @param path
     * @returns {*}
     */
    getUri(path = '') {
        return platform.prefix(`/press/menu/${path}`);
    }

    /**
     *
     * @param blocks
     */
    hiddenBlocks(blocks) {
        if (!Array.isArray((blocks))) {
            blocks = [blocks];
        }
        blocks.forEach(function (element) {
            document.getElementById(element).classList.add("none");
        });
    }

    /**
     *
     * @param blocks
     */
    showBlocks(blocks) {
        if (!Array.isArray((blocks))) {
            blocks = [blocks];
        }
        blocks.forEach(function (element) {
            document.getElementById(element).classList.remove("none");
        });
    }
}