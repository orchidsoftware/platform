document.addEventListener('turbolinks:load', function () {
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
      errors: {
        title: false,
        label: false,
        slug: false,
      },
    },
    computed: {
      menuData: function () {
        return {
          label: this.label,
          title: this.title,
          auth: this.auth,
          slug: this.slug,
          robot: this.robot,
          style: this.style,
          target: this.target,
        }
      }
    },
    methods: {
      load: function (object) {
        this.id = object.id;
        this.label = object.label;
        this.slug = object.slug;
        this.auth = object.auth;
        this.robot = object.robot;
        this.style = object.style;
        this.target = object.target;
        this.title = object.title;
      },
      checkForm: function () {
        let valid = false;
        this.errors = {
          title: false,
          label: false,
          slug: false,
        };

        if (!this.title) {
          this.errors.title = valid = true;
        }

        if (!this.label) {
          this.errors.label = valid = true;
        }

        if (!this.slug) {
          this.errors.slug = valid = true;
        }

        return !valid;
      },
      add: function () {
        if (!this.checkForm()) {
          return;
        }
        let $vm = this, $dd = $('.dd'),
          data = {menu: $dd.attr('data-name'), lang: $dd.attr('data-lang'), data: this.menuData};

        axios
          .get(dashboard.prefix('/systems/menu/create/'), {params: data})
          .then(function (response) {
            addItem(response.data.id)
          });

        function addItem(id) {
          $('.dd > .dd-list').append(
            "<li class='dd-item dd3-item' data-id='" + id + "'> " +
            "<div class='dd-handle dd3-handle'>Drag</div><div class='dd3-content'>" + $vm.label + '</div> ' +
            "<div class='edit icon-pencil'></div>" + '</li>',
          );

          $('li[data-id=' + id + ']').data($vm.menuData);

          $vm.count--;
          sortItems();
          $vm.clear();
          $vm.send();
        }
      },
      edit: function (element) {
        let data = $(element)
          .parent()
          .data();
        data.label = $(element)
          .prev()
          .text();
        this.load(data);
      },
      save: function () {
        if (!this.checkForm()) {
          return;
        }

        $('li[data-id=' + this.id + ']').data(this.menuData);
        $('li[data-id=' + this.id + '] > .dd3-content').html(this.label);

        this.clear();
        $('#menuEdit').modal('hide');
        menu.send();
      },
      destroy: function (id) {
        axios
          .delete(dashboard.prefix('/systems/menu/' + id))
          .then(function (response) {
          });
      },
      remove: function () {
        $('li[data-id=' + this.id + ']').remove();
        $('#menuEdit').modal('hide');
        this.destroy(this.id);
        this.clear();
      },
      clear: function () {
        this.label = '';
        this.title = '';
        this.auth = 0;
        this.slug = '';
        this.robot = 'follow';
        this.style = '';
        this.target = '_self';
        this.id = '';
      },
      send: function () {
        let name = $('.dd').attr('data-name');

        let data = {
          lang: $('.dd').attr('data-lang'),
          data: $('.dd').nestable('serialize'),
        };

        axios
          .put(dashboard.prefix('/systems/menu/' + name), data)
          .then(function (response) {
          });
      },
      exist: function () {
        return (
          Number.isInteger(this.id) &&
          $('li[data-id=' + this.id + ']').length > 0
        );
      },
    },
  });

  let $dd = $('.dd');

  $dd.nestable({});

  sortItems();

  $dd
    .on('change', function () {
      sortItems();

      menu.send();
    })
    .on('click', '.edit', function () {
      menu.edit(this);
    });

  $('.menu-save').click(function () {
    menu.send();
  });

  function sortItems() {
    $('.dd-item').each(function (i, item) {
      $(item).data({
        sort: i,
      });
    });
  }
});
