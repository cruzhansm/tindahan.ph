// import { suspendListing } from '../../db-methods/update.js';
// import { suspendProdModal } from '../../db-methods/retrieve.js';
// import { LISTINGS } from '../../live-listing.js';

window.showProdModal = function showProdModal(selectedModal, prodId, index) {
  const modal = new bootstrap.Modal(selectedModal);
  const modalBody = document.querySelector('.suspend-modal-body');

  modal.show();
  const listing = LISTINGS.find((a) => a.products.product_id == prodId);
  suspendProdModal(listing, modalBody);
};

window.dismissProdModal = function dismissProdModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  modal.hide();
};

window.suspendedProdModal = function suspendedProdModal(selectedModal, prodId) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const listing = LISTINGS.find((a) => a.products.product_id == prodId);

  console.log(listing);
  suspendListing(listing, modal);
};
