import {Controller} from "stimulus"

export default class extends Controller {

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

    connect() {

        let menu = this;

        $('.dd').nestable({})
            .on('change', () => {
                $('.dd-item').each((i, item) => {
                    $(item).data({
                        sort: i,
                    });
                });

                menu.send();
            }).on('click', '.edit', function () {
            menu.edit(this);
        });

        $('.dd-item').each((i, item) => {
            $(item).data({
                sort: i,
            });
        });


        this.checkExist();
    }

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

    edit(element) {
        let data = $(element)
            .parent()
            .data();
        data.label = $(element)
            .prev()
            .text();
        this.load(data);
    }

    add() {
        if (!this.checkForm()) {
            return;
        }

        $('.dd > .dd-list').append(
            `<li class='dd-item dd3-item' data-id='${this.count}'> <div  class='dd-handle dd3-handle'>Drag</div><div  class='dd3-content'>${this.labelTarget.value}</div> <div  class='edit icon-pencil'></div></li>`,
        );

        $(`li[data-id=${this.count}]`).data({
            label: this.labelTarget.value,
            title: this.titleTarget.value,
            auth: this.authTarget.value,
            slug: this.slugTarget.value,
            robot: this.robotTarget.value,
            style: this.styleTarget.value,
            target: this.targetTarget.value,
        });

        this.count--;
        this.clear();
        this.send();
    }

    save() {
        if (!this.checkForm()) {
            return;
        }

        $(`li[data-id=${this.id}]`).data({
            label: this.labelTarget.value,
            title: this.titleTarget.value,
            auth: this.authTarget.value,
            slug: this.slugTarget.value,
            robot: this.robotTarget.value,
            style: this.styleTarget.value,
            target: this.targetTarget.value,
        });
        $(`li[data-id=${this.id}] > .dd3-content`).html(this.labelTarget.value);

        this.clear();
        this.send();
    }

    destroy(id) {
        axios
            .delete(platform.prefix(`/press/menu/${id}`))
            .then(response => {});
    }

    remove() {
        $(`li[data-id=${this.id}]`).remove();
        this.destroy(this.id);
        this.clear();
    }

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
        window.Turbolinks.visit(window.location, { action: 'replace' });
    }

    send() {
        let name = $('.dd').attr('data-name');
        let data = {
            lang: $('.dd').attr('data-lang'),
            data: $('.dd').nestable('serialize'),
        };

        axios
            .put(platform.prefix(`/press/menu/${name}`), data)
            .then(response => {});
    }

    checkForm() {
        if (!this.labelTarget.value) {
            document.getElementById('errors.label').classList.remove("none");
            return false;
        }

        if (!this.titleTarget.value) {
            document.getElementById('errors.title').classList.remove("none");
            return false;
        }

        if (!this.slugTarget.value) {
            document.getElementById('errors.slug').classList.remove("none");
            return false;
        }

        document.getElementById('errors.slug').classList.add("none");
        document.getElementById('errors.label').classList.add("none");
        document.getElementById('errors.title').classList.add("none");

        return true;
    }


    checkExist() {
        if(this.exist()){
            document.getElementById('menu.remove').classList.remove("none");
            document.getElementById('menu.reset').classList.remove("none");
            document.getElementById('menu.add').classList.add("none");
            document.getElementById('menu.save').classList.remove("none");
        }else{
            document.getElementById('menu.remove').classList.add("none");
            document.getElementById('menu.reset').classList.add("none");
            document.getElementById('menu.add').classList.remove("none");
            document.getElementById('menu.save').classList.add("none");
        }
    }

    exist() {
        return Number.isInteger(this.id) &&
            $(`li[data-id=${this.id}]`).length > 0;
    }

}
