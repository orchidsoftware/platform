window.dashboard = {
  /**
   * Field code
   */
  fields: {
    tinymce: require('./fields/tinymce'),
    simplemde: require('./fields/simplemde'),
  },

  /**
   *
   * @param path
   * @returns {*}
   */
  prefix: function(path) {
    let prefix = document.head.querySelector('meta[name="dashboard-prefix"]');

    if (prefix && prefix.content.charAt(0) !== '/') {
      prefix = '/' + prefix.content;
    }

    return prefix + path;
  },

  /**
   *
   * @param message
   * @param type
   * @param target
   */
  alert: function(message, type = 'danger', target = '#dashboard-alerts') {
    $(target).append(
      $('<div/>', {
        class: 'alert m-b-none alert-' + type,
        text: message,
      }).append(
        $('<button/>', {
          class: 'close',
          'data-dismiss': 'alert',
          'aria-label': 'Close',
          'aria-hidden': 'true',
        }).append($('<span/>', { 'aria-hidden': 'true', html: '&times;' })),
      ),
      $('<div/>', { class: 'clearfix' }),
    );
  },

  /**
   *
   * @param idForm
   * @param message
   * @returns {boolean}
   */
  validateForm: function(idForm, message) {
    if (!document.getElementById(idForm).checkValidity()) {
      window.dashboard.alert(message, 'warning b-b');
      return false;
    }
    return true;
  },
};
