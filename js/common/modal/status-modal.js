export class StatusModal {
  status;

  constructor(status) {
    this.status = status;
  }

  show() {
    const statusModal = this.#createStatusModal();

    document.querySelector('body').prepend(statusModal);
  }

  dismiss() {
    const statusModal = document.querySelector('#statusModal');

    statusModal.classList.add = 'dismiss';
    setTimeout(() => statusModal.remove(), 300);
  }

  dismissAfter(delay) {
    const statusModal = document.querySelector('#statusModal');

    statusModal.classList.add = 'dismiss';
    setTimeout(() => statusModal.remove(), delay + 300);
  }

  static getActive() {
    return document.querySelector('#statusModal');
  }

  #createStatusModal() {
    const statusModal = document.createElement('div');

    statusModal.setAttribute('id', 'statusModal');
    statusModal.classList.add('status-modal');
    statusModal.innerHTML = `
      <div class="status-modal-container">
        <div class="status-modal-content">
          ${this.status}
        </div>
      </div>
    `;

    return statusModal;
  }
}
