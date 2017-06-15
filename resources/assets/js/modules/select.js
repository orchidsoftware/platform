$(function () {
    $(".select2").select2({
        width: '100%'
    });
});


$(function () {
    $('.select2-tags').select2({
        width: '100%',
        tags: true,
        ajax: {
            url: function (params) {
                return '/dashboard/tools/tags/' + params.term;
            },
            delay: 250,
            processResults: function (data, page) {
                return {
                    results: data
                };
            }
        }
    });
});
