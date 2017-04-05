$(function () {
    $('.datetimepicker').datetimepicker({
        defaultDate: moment().format('YYYY-MM-DD HH:mm:ss'),
        format: 'YYYY-MM-DD HH:mm:ss',
        locale: $('html').attr('lang'),
        icons: {
            time: "icon-clock",
            date: "icon-event",
            up: "icon-arrow-up",
            down: "icon-arrow-down",
            right: "icon-arrow-right",
            left: "icon-arrow-left"
        }
    });
});

