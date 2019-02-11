import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     *
     */
    send(event) {

        let form = new FormData(event.target.form);
        let action = event.srcElement.getAttribute('formaction');
        let textValidation = event.srcElement.getAttribute('data-text-validation');

        let validation = window.platform.validateForm('post-form', textValidation);

        if (!validation) {
            return false;
        }

        axios.post(action, form)
            .then((response) => {
                let url = response.request.responseURL;
                Turbolinks.controller.cache.put(url, Turbolinks.Snapshot.wrap(response.data));
                Turbolinks.visit(url, {action: 'restore'});
            })
            .catch((error) => {
                console.warn(error);
            });

        return false;
    }

}
