import { suspendUser } from '../../db-methods/update.js'
import { suspendModalInfo } from '/tindahan.ph/js/admin/db-methods/retrieve.js'
import { USERS } from '/tindahan.ph/js/admin/user-management.js'

window.showSuspendModal = function showSuspendModal(selectedModal, userId) {
  const modal = new bootstrap.Modal(selectedModal);
  const modalBody = document.querySelector('.suspend-modal-body');

  modal.show();
  const user = USERS.find((a) => a.user_id == userId);
  suspendModalInfo(user, modalBody);
}

window.dismissSuspendModal = function dismissSuspendModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  modal.hide();
}

window.suspendedModal = function suspendedModal(selectedModal, userId) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const user = USERS.find((a) => a.user_id == userId);

  console.log(user);
  suspendUser(user, modal);
}