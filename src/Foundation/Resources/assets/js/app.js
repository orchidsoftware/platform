Vue.http.headers.common['X-CSRF-TOKEN'] = $('[name="csrf_token"]').attr('content');
$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
    });
});
