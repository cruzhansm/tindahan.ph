import { getPendingPartnerDetails } from '/tindahan.ph/js/admin/db-methods/retrieve.js'

window.showModal = function showModal(selectedModal, applicationId) {
  const modal = new bootstrap.Modal(selectedModal);
  const modalBody = document.querySelector('.partner-modal-body');

  modal.show();
  getPendingPartnerDetails(applicationId, modalBody);

  console.log(applicationId);
};

window.dismissModal = function dismissModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const form = selectedModal.querySelector('form');

  resetFlags().then(stripInputListeners(form)).then(removeAllValidation(form));

  modal.hide();
};
