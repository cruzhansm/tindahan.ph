import { suspendProdModal } from '/tindahan.ph/js/admin/db-methods/retrieve2.js';
import { deleteProdModal } from '../../db-methods/retrieve2.js';
import { LISTINGS } from '/tindahan.ph/js/admin/live-listing.js';
import { StatusModal } from '/tindahan.ph/js/common/modal/status-modal.js';

window.showProdModal = function showProdModal(selectedModal, prodId, index) {
  const modal = new bootstrap.Modal(selectedModal);
  const modalBody = document.querySelector('.suspend-modal-body');

  modal.show();
  const listing = LISTINGS[index];
  console.log(listing);
  suspendProdModal(listing, modalBody, index);
};

window.showDeleteModal = function showDeleteModal(
  selectedModal,
  prodId,
  index
) {
  const modal = new bootstrap.Modal(selectedModal);
  const modalBody = document.querySelector('.delete-modal-body');

  modal.show();
  const listing = LISTINGS[index];
  console.log(listing);
  deleteProdModal(listing, modalBody, index);
};

window.dismissProdModal = function dismissProdModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  modal.hide();
};

window.dismissDeleteModal = function dismissDeleteModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  modal.hide();
};

window.suspendedProdModal = function suspendedProdModal(
  selectedModal,
  prodId,
  index
) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const listing = LISTINGS[index];

  console.log(listing);
  suspendModalV2(listing, modal);
};

window.deletedProdModal = function deletedProdModal(selectedModal, index) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const listing = LISTINGS[index];

  deleteModalV2(listing, modal);
};

function suspendModalV2(listing, modal) {
  // Suspending user
  $.ajax({
    url: '/tindahan.ph/php/products/crud.php',
    data: {
      type: 'suspend-listing',
      listing: listing,
    },
    success: (data) => {
      let result = JSON.parse(data);
      console.log(result);
      if (result == true) {
        const statusModal = new StatusModal('Product is suspended!');
        statusModal.show();
        statusModal.dismissAfter(1000);
        modal.hide();
        window.location.reload();
      } else {
        const statusModal = new StatusModal(result.error_msg);
        statusModal.show();
        statusModal.dismissAfter(1000);
        modal.hide();
        window.location.reload();
      }
    },
  });
}

function deleteModalV2(listing, modal) {
  // Suspending user
  $.ajax({
    url: '/tindahan.ph/php/products/crud.php',
    data: {
      type: 'delete-listing',
      listing: listing,
    },
    success: (data) => {
      let result = JSON.parse(data);
      console.log(result);
      if (result == true) {
        const statusModal = new StatusModal('Product is deleted!');
        statusModal.show();
        statusModal.dismissAfter(1000);
        modal.hide();
        window.location.reload();
      } else {
        const statusModal = new StatusModal(result.error_msg);
        statusModal.show();
        statusModal.dismissAfter(1000);
        modal.hide();
        window.location.reload();
      }
    },
  });
}
