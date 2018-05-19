import {Controller} from "stimulus"

export default class extends Controller {

    static targets = [
        "menu_id",
        "menu_label",
        "menu_slug",
        "menu_auth",
        "menu_robot",
        "menu_style",
        "menu_target",
        "menu_title",
    ];

    connect() {
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


        $('.menu-save').click(() => {
            menu.send();
        });
    }


    load(object) {
        this.id = object.id;
        this.label = object.label;
        this.slug = object.slug;
        this.auth = object.auth;
        this.robot = object.robot;
        this.style = object.style;
        this.target = object.target;
        this.title = object.title;
    }

}
