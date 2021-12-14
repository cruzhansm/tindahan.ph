import { deleteUser } from '../../db-methods/update.js'
import { deleteModalInfo } from '/tindahan.ph/js/admin/db-methods/retrieve.js'
import { USERS } from '/tindahan.ph/js/admin/user-management.js'

window.showDeleteModal = function showDeleteModal(selectedModal, userId) {
  const modal = new bootstrap.Modal(selectedModal);
  const modalBody = document.querySelector('.delete-modal-body');

  modal.show();
  const user = USERS.find((a) => a.user_id == userId);
  deleteModalInfo(user, modalBody);
}

window.dismissDeleteModal = function dismissDeleteModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  modal.hide();
}

window.deletedModal = function deletedModal(selectedModal, userId) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const user = USERS.find((a) => a.user_id == userId);

  console.log(user);
  deleteUser(user, modal);
}