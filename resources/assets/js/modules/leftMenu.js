document.addEventListener('turbolinks:load', function() {
  $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this)
      .parent()
      .siblings()
      .removeClass('open');
    $(this)
      .parent()
      .toggleClass('open');
  });


let activeMenu = false;

$('#aside-wrap-list').children('.tab-pane').each(function () {
    if($(this).hasClass('active')){
        activeMenu = true;
    }
});

if(!activeMenu){
    $('#menu-notifications').addClass('active')
}

});
