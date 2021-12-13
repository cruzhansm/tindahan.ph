import { LISTING_APPLICATIONS } from "../pending-lists-functions.js"
import { StatusModal } from "/tindahan.ph/js/common/modal/status-modal.js"

export function approvePartner(details, modal) {    // Approval of Partner in modal (complete)
  $.ajax({
    url: '/tindahan.ph/php/partner-applications/crud.php',
    data: {
      type: 'approve-pending-partner',
      details: details
    },
    success: (data) => {
      let result = JSON.parse(data);
      let div = document.getElementById(`a${details.application_id}`);
      console.log(div);
      if (result == true) {
        const statusModal = new StatusModal("Application approved!")
        statusModal.show()
        statusModal.dismissAfter(1000)
        modal.hide()
        div.remove()
      } else {
        const statusModal = new StatusModal(result.error_msg)
        statusModal.show()
        statusModal.dismissAfter(1000)
        modal.hide()
      }
    }
  });
}

export function approvePartnerV2(details) {   // Approval of Partner in tab (works, but modal still shows up)
  $.ajax({
    url: '/tindahan.ph/php/partner-applications/crud.php',
    data: {
      type: 'approve-pending-partner',
      details: details
    },
    success: (data) => {
      let result = JSON.parse(data);
      let div = document.getElementById(`a${details.application_id}`);
      console.log(div);
      if (result == true) {
        const statusModal = new StatusModal("Application approved!")
        statusModal.show()
        statusModal.dismissAfter(1000)
        div.remove()
      } else {
        const statusModal = new StatusModal(result.error_msg)
        statusModal.show()
        statusModal.dismissAfter(1000)
      }
    }
  });
}

export function approveListing(details, modal) {    // Approval of Listing in modal (incomplete)
  $.ajax({
    url: '/tindahan.ph/php/listing-applications/crud.php',
    data: {
      type: 'approve-pending-partner',
      details: details
    },
    success: (data) => {
      let result = data;
      let div = document.getElementById(`b${details.application_id}`);
      console.log(div);
      if (result == true) {
        const statusModal = new StatusModal("Listing approved!")
        statusModal.show()
        statusModal.dismissAfter(1000)
        modal.hide()
        div.remove()
      } else {
        const statusModal = new StatusModal(result.error_msg)
        statusModal.show()
        statusModal.dismissAfter(1000)
        modal.hide()
      }
    }
  });
}

export function approveListingV2(index) {   // Approval of Listing in tab (works, but modal still shows up)
  $.ajax({
    url: '/tindahan.ph/php/listing-applications/crud.php',
    data: {
      type: 'approve-pending-listing',
      applicationDetails: LISTING_APPLICATIONS[index]
    },
    success: (data) => {
      let result = data;
      let div = document.getElementById(`b${LISTING_APPLICATIONS[index].application.application_id}`);
      console.log(result);
      if (result == true) {
        const statusModal = new StatusModal("Listing approved!")
        statusModal.show()
        statusModal.dismissAfter(1000)
        div.remove()
      } else {
        const statusModal = new StatusModal(result.error_msg)
        statusModal.show()
        statusModal.dismissAfter(1000)
      }
    }
  });
}