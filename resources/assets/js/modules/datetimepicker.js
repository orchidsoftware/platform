document.addEventListener('turbolinks:load', function () {
    $('.datetimepicker').datetimepicker({
        defaultDate: moment(),
        locale: $('html').attr('lang'),
        icons: {
            time: 'icon-clock',
            date: 'icon-event',
            up: 'icon-arrow-up',
            down: 'icon-arrow-down',
            right: 'icon-arrow-right',
            left: 'icon-arrow-left',
        },
    });
});
