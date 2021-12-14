import { getPendingPartnerDetails } from '/tindahan.ph/js/admin/db-methods/retrieve.js'
import { approvePartner } from '/tindahan.ph/js/admin/db-methods/create.js'
import { approvePartnerV2 } from '/tindahan.ph/js/admin/db-methods/create.js'
import { rejectPartner } from '/tindahan.ph/js/admin/db-methods/update.js'
import { rejectPartnerV2 } from '/tindahan.ph/js/admin/db-methods/update.js'
import { APPLICATIONS } from '/tindahan.ph/js/admin/pending-lists-functions.js'

window.showModal = function showModal(selectedModal, applicationId) {
  const modal = new bootstrap.Modal(selectedModal);
  const modalBody = document.querySelector('.partner-modal-body');

  modal.show();
  const application = APPLICATIONS.find((a) => a.application_id == applicationId);
  console.log(APPLICATIONS);
  getPendingPartnerDetails(application, modalBody);

}

window.dismissModal = function dismissModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  modal.hide();
}

window.approvedModal = function approvedModal(selectedModal, applicationId) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  const application = APPLICATIONS.find((a) => a.application_id == applicationId);
  approvePartner(application, modal);
}

window.approvedTab = function approvedTab(applicationId) {
  const application = APPLICATIONS.find((a) => a.application_id == applicationId);
  approvePartnerV2(application);
}

window.rejectedModal = function rejectedModal(selectedModal, applicationId) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  const application = APPLICATIONS.find((a) => a.application_id == applicationId);
  console.log(APPLICATIONS);
  rejectPartner(application, modal);
}

window.rejectedTab = function rejectedTab(applicationId) {
  const application = APPLICATIONS.find((a) => a.application_id == applicationId);
  rejectPartnerV2(application);
}