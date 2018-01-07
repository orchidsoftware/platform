document.addEventListener('turbolinks:load', function() {
    $('input[data-mask]').each(function() {
        Inputmask($(this).data('mask')).mask($(this));
    });
});
