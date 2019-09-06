import {Controller} from 'stimulus';

export default class extends Controller {

  /**
   *
   * @param props
   */
  constructor(props) {
    super(props);
    this.template = '';
  }

  /**
   *
   */
  connect() {
    if (!('content' in document.createElement('template'))) {
      console.warn('Your browser does not support <template>');
    }

    this.template = this.element.querySelector('#toast');

    this.alert('Validation error', 'Please check the entered data, it may be necessary to specify in other languages.', 'danger');
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
