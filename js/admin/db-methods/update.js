import { StatusModal } from "/tindahan.ph/js/common/modal/status-modal.js"

export function suspendUser(user, modal) {
  $.ajax({
    url: '/tindahan.ph/php/user/crud.php',
    data: {
      type: 'suspend-user',
      user: user
    },
    success: (data) => {
      let result = JSON.parse(data);
      if (result == true) {
        const statusModal = new StatusModal("User is suspended!");
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
    }
  })
}

export function deleteUser(user, modal) {
  $.ajax({
    url: '/tindahan.ph/php/user/crud.php',
    data: {
      type: 'delete-user',
      user: user
    },
    success: (data) => {
      let result = JSON.parse(data);
      if (result == true) {
        const statusModal = new StatusModal("User is deleted!");
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
    }
  })
}