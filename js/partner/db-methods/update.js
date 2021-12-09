import { StatusModal } from '../../common/modal/status-modal.js';

export function updatePartnerStoreDetails(editDetails) {
  console.log(editDetails);

  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/partner/crud.php',
    data: {
      type: 'update-store-profile',
      editDetails: JSON.stringify(editDetails),
    },
    success: (result) => {
      result = JSON.parse(result);

      if (result === true) {
        const status = new StatusModal('Updated!');
        status.show();
        status.dismissAfter(1000);
        setTimeout(() => window.location.reload(), 800);
      } else {
        const status = new StatusModal(result.error_msg);
        status.show();
        status.dismissAfter(2000);
      }
    },
  });
}
