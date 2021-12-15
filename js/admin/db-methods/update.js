import { LISTINGS } from '/tindahan.ph/js/admin/live-listing.js';

// import { APPLICATIONS } from '../pending-lists-functions.js';
import { LISTING_APPLICATIONS } from '../pending-lists-functions.js';
import { StatusModal } from '/tindahan.ph/js/common/modal/status-modal.js';

export function rejectPartner(details, modal) {
  // Rejecting Partner in modal (complete)
  $.ajax({
    url: '/tindahan.ph/php/partner-applications/crud.php',
    data: {
      type: 'reject-pending-partner',
      details: details,
    },
    success: (data) => {
      let result = JSON.parse(data);
      let div = document.getElementById(`a${details.application_id}`);
      console.log(div);
      if (result == true) {
        const statusModal = new StatusModal('Application rejected!');
        statusModal.show();
        statusModal.dismissAfter(1000);
        modal.hide();
        div.remove();
      } else {
        const statusModal = new StatusModal(result.error_msg);
        statusModal.show();
        statusModal.dismissAfter(1000);
        modal.hide();
      }
    },
  });
}

export function rejectPartnerV2(details) {
  // Rejecting Partner in tab (works, but modal still shows up)
  $.ajax({
    url: '/tindahan.ph/php/partner-applications/crud.php',
    data: {
      type: 'reject-pending-partner',
      details: details,
    },
    success: (data) => {
      let result = JSON.parse(data);
      let div = document.getElementById(`a${details.application_id}`);
      console.log(div);
      if (result == true) {
        const statusModal = new StatusModal('Application rejected!');
        statusModal.show();
        statusModal.dismissAfter(1000);
        div.remove();
      } else {
        const statusModal = new StatusModal(result.error_msg);
        statusModal.show();
        statusModal.dismissAfter(1000);
      }
    },
  });
}

export function rejectListing(index, modal) {
  // Rejecting Listing in modal (incomplete)
  // console.log(LISTING_APPLICATIONS[index]);

  $.ajax({
    url: '/tindahan.ph/php/listing-applications/crud.php',
    data: {
      type: 'reject-pending-listing',
      applicationDetails: LISTING_APPLICATIONS[index],
    },
    success: (data) => {
      let result = data;
      let div = document.getElementById(
        `b${LISTING_APPLICATIONS[index].application.application_id}`
      );
      console.log(div);
      const statusModal = new StatusModal('Listing rejected!');
      statusModal.show();
      statusModal.dismissAfter(1000);
      modal.hide();
      div.remove();
    },
  });
}

export function rejectListingV2(index) {
  // Rejecting Listing in tab (works, but modal still shows up)
  $.ajax({
    url: '/tindahan.ph/php/listing-applications/crud.php',
    data: {
      type: 'reject-pending-listing',
      applicationDetails: LISTING_APPLICATIONS[index],
    },
    success: (data) => {
      let result = data;
      let div = document.getElementById(
        `b${LISTING_APPLICATIONS[index].application.application_id}`
      );
      console.log(div);
      if (result == true) {
        const statusModal = new StatusModal('Listing rejected!');
        statusModal.show();
        statusModal.dismissAfter(1000);
        div.remove();
      } else {
        const statusModal = new StatusModal(result.error_msg);
        statusModal.show();
        statusModal.dismissAfter(1000);
      }
    },
  });
}

export function suspendUser(user, modal) {
  // Suspending user
  $.ajax({
    url: '/tindahan.ph/php/user/crud.php',
    data: {
      type: 'suspend-user',
      user: user,
    },
    success: (data) => {
      let result = JSON.parse(data);
      if (result == true) {
        const statusModal = new StatusModal('User is suspended!');
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

export function deleteUser(user, modal) {
  // Deleting user
  $.ajax({
    url: '/tindahan.ph/php/user/crud.php',
    data: {
      type: 'delete-user',
      user: user,
    },
    success: (data) => {
      let result = JSON.parse(data);
      if (result == true) {
        const statusModal = new StatusModal('User is deleted!');
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
