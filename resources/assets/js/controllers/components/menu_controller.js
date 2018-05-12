/*
import {Controller} from "stimulus"

export default class extends Controller {

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

}
*/