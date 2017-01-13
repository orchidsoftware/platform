$(function () {
    $('.datetimepicker').datetimepicker({
        defaultDate: moment().format('YYYY-MM-DD HH:mm:ss'),
        format: 'YYYY-MM-DD HH:mm:ss',
        locale:  $('html').attr('lang'),
        icons: {
            time: "ion-clock",
            date: "ion-calendar",
            up: "ion-ios-arrow-up",
            down: "ion-ios-arrow-down"
        }
    });
});

