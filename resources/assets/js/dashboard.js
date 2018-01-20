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
  alert: function(message, type, target) {
    $(target).append(
      $('<div/>', { class: 'alert alert-' + type, text: message }).append(
        $('<a/>', {
          class: 'close',
          'data-dismiss': 'alert',
          'aria-label': 'Close',
        }).append($('<span/>', { 'aria-hidden': 'true', html: '&times;' })),
      ),
      $('<div/>', { class: 'clearfix' }),
    );
  },
};
