/**
 * Reload GoogleMaps Tabs
 */
document.addEventListener('DOMContentLoaded', function () {
    $('#post').find('a[data-toggle="tab"]').on('shown.bs.tab', function () {
        setTimeout(function () {
            window.dispatchEvent(new Event('resize'));
        }, 1000);
    });
});
