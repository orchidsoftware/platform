/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

document.addEventListener('turbolinks:load', function () {
    let token = document.head.querySelector('meta[name="csrf_token"]');

    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        console.error(
            'CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token',
        );
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'),
        },
    });
});
