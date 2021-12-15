import { StatusModal } from '../../common/modal/status-modal.js';

export function updateUserInfo(updateInfo) {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/common/crud.php',
    data: {
      type: 'update-user-info',
      updateDetails: JSON.stringify(updateInfo),
    },
    success: (data) => {
      data = JSON.parse(data);

      if (data === true) {
        const status = new StatusModal('Updated!');
        status.show();
        status.dismissAfter(1000);
        setTimeout(() => window.location.reload(), 800);
      } else {
        const status = new StatusModal(data.error_msg);
        status.show();
        status.dismissAfter(2000);
      }
    }
  });
}

export function updateEmail(email) {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/common/crud.php',
    data: {
      type: 'update-email',
      newEmail: email
    },
    success: (data) => {
      
      data = JSON.parse(data);
      console.log(data);

      if (data === true) {
        const status = new StatusModal('Updated!');
        status.show();
        status.dismissAfter(1000);
        setTimeout(() => window.location.reload(), 800);
      } else {
        const status = new StatusModal(data.error_msg);
        status.show();
        status.dismissAfter(2000);
      }
    }
  })
}

export function updatePassword(password) {
  console.log(password);
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/common/crud.php',
    data: {
      type: 'update-password',
      newPass: password
    },
    success: (data) => {
      console.log(data);
      data = JSON.parse(data);

      if (data === true) {
        const status = new StatusModal('Updated!');
        status.show();
        status.dismissAfter(1000);
        setTimeout(() => window.location.reload(), 800);
      } else {
        const status = new StatusModal(data.error_msg);
        status.show();
        status.dismissAfter(2000);
      }
    }
  })
}