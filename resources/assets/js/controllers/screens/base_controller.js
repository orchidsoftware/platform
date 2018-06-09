import {Controller} from "stimulus";

export default class extends Controller {


    /**
     *
     * @param event
     */
    targetModal(event) {
        let key = event.target.dataset.modalKey;

        $('#title-modal-'+key).html(event.target.dataset.modalTitle);
        $('#submit-modal-'+key).attr('formaction', event.target.dataset.modalAction);
        $('#screen-modal-type-'+key).addClass($('#show-button-modal-'+key).data('modalType'));
        $('#screen-modal-'+ key).modal('toggle');
    }

    /**
     *
     * @param event
     */
    targetAsyncModal(event)
    {
        this.targetModal(event);
        console.log('Тут я должен подгрузить новый html с сервера');

        return event.preventDefault();
    }

}