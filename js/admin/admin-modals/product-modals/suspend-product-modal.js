import { suspendListing } from '/tindahan.ph/js/admin/db-methods/update.js'
import { suspendProdModal } from '/tindahan.ph/js/admin/db-methods/retrieve.js'
import { LISTINGS } from '/tindahan.ph/js/admin/live-listing.js'

window.showProdModal = function showProdModal(selectedModal, prodId, index) {
  const modal = new bootstrap.Modal(selectedModal);
  const modalBody = document.querySelector('.suspend-modal-body');

  modal.show();
  const listing = LISTINGS.find((a) => a.products.product_id == prodId);
  suspendProdModal(listing, modalBody);
}

window.dismissProdModal = function dismissProdModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  modal.hide();
}

window.suspendedProdModal = function suspendedProdModal(selectedModal, prodId) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const listing = LISTINGS.find((a) => a.products.product_id == prodId);

  console.log(listing);
  suspendListing(listing, modal);
}