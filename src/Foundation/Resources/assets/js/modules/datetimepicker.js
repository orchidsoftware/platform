$(function () {
    $('.datetimepicker').datetimepicker({
        defaultDate: moment().format('YYYY-MM-DD HH:mm:ss'),
        format: 'YYYY-MM-DD HH:mm:ss',
        locale:  $('html').attr('lang'),
        icons: {
            time: "icon-clock",
            date: "icon-event",
            up: "icon-arrow-up",
            down: "icon-arrow-down"
        }
    });

    $('.date-picker').datetimepicker({
        defaultDate: moment().format('YYYY-MM-DD'),
        format: 'YYYY-MM-DD',
        locale:  $('html').attr('lang'),
        icons: {
            time: "icon-clock",
            date: "icon-event",
            up: "icon-arrow-up",
            down: "icon-arrow-down"
        }
    });

    $('.time-picker').datetimepicker({
        format: 'HH:mm',
        locale:  $('html').attr('lang'),
        icons: {
            time: "icon-clock",
            date: "icon-event",
            up: "icon-arrow-up",
            down: "icon-arrow-down"
        }
    });
});

