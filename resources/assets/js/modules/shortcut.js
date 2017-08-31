$(window).keypress(function (event) {
    if (!(event.which == 115 && event.ctrlKey) && !(event.which == 19)) return true;

    if ($('.btn-save').length > 0) {
        $('.btn-save').trigger('click');
    }

    event.preventDefault();
    return false;
});
