$(function () {
    $(".select2").select2({
        width: '100%'
    });
});


$(function () {
    $('.select2-tags').select2({
        theme: "classic",
        templateResult: function formatState (state) {
            if (!state.id || !state.count) { return state.text; }

            var str ='<span>' + state.text + '</span>' +' <span class="pull-right badge bg-info">' + state.count + '</span>';


            return  $(str);
        },
        escapeMarkup: function(m) {
            return m;
        },
        width: '100%',
        tags: true,
        cache: true,
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
