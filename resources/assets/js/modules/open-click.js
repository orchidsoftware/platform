$(function () {
    $('.click').click(function () {
        var target = $(this).data("target");
        var toggle = $(this).data("toggle");

        if ($(target).hasClass(toggle)) {
            $(target).removeClass(toggle);
        }
        else {
            $(target).addClass(toggle);
        }
    });
});
