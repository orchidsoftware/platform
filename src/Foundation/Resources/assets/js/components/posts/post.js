if (document.getElementsByClassName('route-app')) {

    let postApp = null;
    document.addEventListener('DOMContentLoaded', function () {
        postApp = new Vue({
            el: '#route-app'
        });

        $('#post a[data-toggle="tab"]').on('shown.bs.tab', function () {
            setTimeout(function () {
                window.dispatchEvent(new Event('resize'));
            }, 1000);
        });
    });

}
;