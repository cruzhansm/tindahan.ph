import { approveListing, approveListingV2 } from "../db-methods/create.js"
import { getPendingListingDetails } from "../db-methods/retrieve.js"
import { rejectListing, rejectListingV2 } from "../db-methods/update.js"
import { LISTING_APPLICATIONS } from "../pending-lists-functions.js"

//  ALL BASIC SHOW AND DISMISS MODAL
window.listingShowModal = function listingShowModal(selectedModal, applicationId, index) {
  const modal = new bootstrap.Modal(selectedModal);
  const modalBody = document.querySelector('.listing-modal-body');

  modal.show();
  const application = LISTING_APPLICATIONS.find((a) => a.application.application_id == applicationId);
  console.log(index);
  getPendingListingDetails(application, modalBody, index);
}

window.listingDismissModal = function listingDismissModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  modal.hide();
}

//  ALL APPROVAL VERSIONS
window.listingApprovedModal = function listingApprovedModal(selectedModal, applicationId) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  const application = LISTING_APPLICATIONS.find((a) => a.application.application_id == applicationId);
  approveListing(application, modal);
}

window.listingApprovedTab = function listingApprovedTab(index) {
  approveListingV2(index);
}

//  ALL REJECTION APPROVALS
window.listingRejectedModal = function listingRejectedModal(selectedModal, index) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  rejectListing(modal, index);
}

window.listingRejectedTab = function listingRejectedTab(index) {
  rejectListingV2(index);
}