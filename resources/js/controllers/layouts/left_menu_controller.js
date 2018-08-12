import {Controller} from "stimulus";

export default class extends Controller {

    /**
     *
     */
    connect() {
        let activeMenu = false;

        $('#aside-wrap-list').children('.tab-pane').each( () => {
            if ($(this).hasClass('active')) {
                activeMenu = true;
            }
        });

        if (!activeMenu) {
            $('#menu-default').addClass('active')
        }

        $('ul.dropdown-menu [data-toggle=dropdown]').on('click',  (event) => {
            event.preventDefault();
            event.stopPropagation();
            $(this)
                .parent()
                .siblings()
                .removeClass('open');
            $(this)
                .parent()
                .toggleClass('open');
        });
    }


}