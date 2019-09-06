import {Controller} from 'stimulus';

export default class extends Controller {

  /**
   *
   */
  connect() {
    if (!('content' in document.createElement('template'))) {
      console.warn('Your browser does not support <template>');
    }

    this.template = this.element.querySelector('#toast');
  }

  /**
   *
   * @param title
   * @param message
   * @param type
   */
  alert(title, message, type = 'warning') {

    let toast = this.template.content.querySelector('.toast').cloneNode(true);

    toast.innerHTML = toast.innerHTML
      .replace(/{title}/, title)
      .replace(/{message}/, message)
      .replace(/{type}/, type);

    this.element.appendChild(toast);

    $('.toast').on('hidden.bs.toast', (event) => {
      event.target.remove()
    }).toast('show');
  }
}
