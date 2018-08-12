document.addEventListener('turbolinks:load', () => {
  $('.click').click(() => {
    let target = $(this).data('target');
    let toggle = $(this).data('toggle');

    if ($(target).hasClass(toggle)) {
      $(target).removeClass(toggle);
      return;
    }

    $(target).addClass(toggle);
  });
});
