document.addEventListener('turbolinks:load', function() {
  if (document.getElementById('menu-vue') === null) {
    return;
  }

  const menu = new Vue({
    el: '#menu-vue',
    data: {
      count: 0,
      id: '',
      label: '',
      title: '',
      slug: '',
      auth: 0,
      robot: 'follow',
      style: '',
      target: '_self',
    },
    methods: {
      load: function(object) {
        this.id = object.id;
        this.label = object.label;
        this.slug = object.slug;
        this.auth = object.auth;
        this.robot = object.robot;
        this.style = object.style;
        this.target = object.target;
        this.title = object.title;
      },
      add: function() {
        $('.dd > .dd-list').append(
          "<li class='dd-item dd3-item' data-id='" +
            this.count +
            "'> " +
            "<div  class='dd-handle dd3-handle'>Drag</div><div  class='dd3-content'>" +
            this.label +
            '</div> ' +
            "<div  class='edit icon-pencil'></div>" +
            '</li>',
        );

        $('li[data-id=' + this.count + ']').data({
          label: this.label,
          title: this.title,
          auth: this.auth,
          slug: this.slug,
          robot: this.robot,
          style: this.style,
          target: this.target,
        });

        this.count--;
        this.clear();
        this.send();
      },
      addStatic: function(name, slug) {
        if (slug.charAt(0) !== '/') {
          slug = '/' + slug;
        }

        this.label = name;
        this.slug = slug;

        $('#ahref-custom-pages').tab('show');
      },
      edit: function(element) {
        const data = $(element)
          .parent()
          .data();
        data.label = $(element)
          .prev()
          .text();
        this.load(data);
      },
      save: function() {
        $('li[data-id=' + this.id + ']').data({
          label: this.label,
          title: this.title,
          auth: this.auth,
          slug: this.slug,
          robot: this.robot,
          style: this.style,
          target: this.target,
        });
        $('li[data-id=' + this.id + '] > .dd3-content').html(this.label);

        this.clear();
        $('#menuEdit').modal('hide');
        menu.send();
      },
      destroy: function(id) {
        axios
          .delete(dashboard.prefix('/systems/menu/' + id))
          .then(function(response) {});
      },
      remove: function() {
        $('li[data-id=' + this.id + ']').remove();
        $('#menuEdit').modal('hide');
        this.destroy(this.id);
        this.clear();
      },
      clear: function() {
        this.label = '';
        this.title = '';
        this.auth = 0;
        this.slug = '';
        this.robot = 'follow';
        this.style = '';
        this.target = '_self';
        this.id = '';
      },
      send: function() {
        //Отправка данных

        const name = $('.dd').attr('data-name');

        const data = {
          lang: $('.dd').attr('data-lang'),
          data: $('.dd').nestable('serialize'),
        };

        axios
          .put(dashboard.prefix('/systems/menu/' + name), data)
          .then(function(response) {});
      },
      exist: function() {
        return (
          Number.isInteger(this.id) &&
          $('li[data-id=' + this.id + ']').length > 0
        );
      },
    },
  });

  $('.dd').nestable({});

  $('.dd-item').each(function(i, item) {
    $(item).data('sort', i);
  });

  $('.dd').on('change', function() {
    menu.send();
  });

  $('.dd').on('click', '.edit', function() {
    menu.edit(this);
  });

  $('.menu-save').click(function() {
    menu.send();
  });
});
