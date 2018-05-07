document.addEventListener('turbolinks:load', () => {
    if (document.getElementById('menu-vue') === null) {
        return;
    }

    const menu = new Vue({
        el: '#menu-vue',
        data: {
            count: 0,
            id: '',
            label: '',
            title: '',
            slug: '',
            auth: 0,
            robot: 'follow',
            style: '',
            target: '_self',
            errors: {
                title: false,
                label: false,
                slug: false,
            },
        },
        methods: {
            load(object) {
                this.id = object.id;
                this.label = object.label;
                this.slug = object.slug;
                this.auth = object.auth;
                this.robot = object.robot;
                this.style = object.style;
                this.target = object.target;
                this.title = object.title;
            },
            checkForm() {
                let valid = false;
                this.errors = {
                    title: false,
                    label: false,
                    slug: false,
                };

                if (!this.title) {
                    this.errors.title = valid = true;
                }

                if (!this.label) {
                    this.errors.label = valid = true;
                }

                if (!this.slug) {
                    this.errors.slug = valid = true;
                }

                return !valid;
            },
            add() {
                if (!this.checkForm()) {
                    return;
                }

                $('.dd > .dd-list').append(
                    `<li class='dd-item dd3-item' data-id='${this.count}'> <div  class='dd-handle dd3-handle'>Drag</div><div  class='dd3-content'>${this.label}</div> <div  class='edit icon-pencil'></div></li>`,
                );

                $(`li[data-id=${this.count}]`).data({
                    label: this.label,
                    title: this.title,
                    auth: this.auth,
                    slug: this.slug,
                    robot: this.robot,
                    style: this.style,
                    target: this.target,
                });

                this.count--;
                this.clear();
                this.send();
            },
            edit(element) {
                let data = $(element)
                    .parent()
                    .data();
                data.label = $(element)
                    .prev()
                    .text();
                this.load(data);
            },
            save() {
                if (!this.checkForm()) {
                    return;
                }

                $(`li[data-id=${this.id}]`).data({
                    label: this.label,
                    title: this.title,
                    auth: this.auth,
                    slug: this.slug,
                    robot: this.robot,
                    style: this.style,
                    target: this.target,
                });
                $(`li[data-id=${this.id}] > .dd3-content`).html(this.label);

                this.clear();
                $('#menuEdit').modal('hide');
                menu.send();
            },
            destroy(id) {
                axios
                    .delete(dashboard.prefix(`/press/menu/${id}`))
                    .then(response => {});
            },
            remove() {
                $(`li[data-id=${this.id}]`).remove();
                $('#menuEdit').modal('hide');
                this.destroy(this.id);
                this.clear();
            },
            clear() {
                this.label = '';
                this.title = '';
                this.auth = 0;
                this.slug = '';
                this.robot = 'follow';
                this.style = '';
                this.target = '_self';
                this.id = '';
            },
            send() {
                let name = $('.dd').attr('data-name');

                let data = {
                    lang: $('.dd').attr('data-lang'),
                    data: $('.dd').nestable('serialize'),
                };

                axios
                    .put(dashboard.prefix(`/press/menu/${name}`), data)
                    .then(response => {});
            },
            exist() {
                return Number.isInteger(this.id) &&
                    $(`li[data-id=${this.id}]`).length > 0;
            },
        },
    });

    $('.dd').nestable({});

    $('.dd-item').each((i, item) => {
        $(item).data({
            sort: i,
        });
    });

    $('.dd').on('change', () => {
        $('.dd-item').each((i, item) => {
            $(item).data({
                sort: i,
            });
        });

        menu.send();
    });

    $('.dd').on('click', '.edit', function() {
        menu.edit(this);
    });

    $('.menu-save').click(() => {
        menu.send();
    });
});
