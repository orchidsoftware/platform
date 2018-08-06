document.addEventListener('turbolinks:load', function() {
  $('.click').click(function() {
    let target = $(this).data('target');
    let toggle = $(this).data('toggle');

    if ($(target).hasClass(toggle)) {
      $(target).removeClass(toggle);
    } else {
      $(target).addClass(toggle);
    }
  });
});
