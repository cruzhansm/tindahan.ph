import { StatusModal } from '../../common/modal/status-modal.js';

export function insertPartnerApplication(application) {
  let data = new FormData();

  data.append('application', JSON.stringify(application));
  data.append('type', 'partner-application');
  data.append('file', application.storeImg);

  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/partner-applications/crud.php',
    data: data,
    processData: false,
    contentType: false,
    success: (result) => {
      result = JSON.parse(result);

      if (result === true) {
        const test = new StatusModal('Sent!');
        test.show();
        test.dismissAfter(500);
      } else {
        alert(result.error_msg);
      }
    },
  });
}

export function checkoutItems(order) {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/orders/crud.php',
    data: {
      type: 'checkout-cart-items',
      order: JSON.stringify(order),
    },
    success: (result) => {
      result = JSON.parse(result);

      if (result == true) {
        window.location.href =
          '/tindahan.ph/src/user/user-checkout-process.php';
      } else {
        const modal = new StatusModal(result.error + '\n' + result.error_msg);
        modal.show();
        modal.dismissAfter(2000);
      }
    },
  });
}
