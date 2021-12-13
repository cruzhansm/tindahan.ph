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

export function confirmOrder(orderID) {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/orders/crud.php',
    data: {
      type: 'confirm-order',
      orderID: orderID,
    },
    success: (result) => {
      result = JSON.parse(result);

      if (result) {
        const modal = new StatusModal('Order successfully confirmed!');
        modal.show();
        modal.dismissAfter(500);
        window.location.reload();
      }
    },
  });
}

export function shipOrder(orderID) {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/orders/crud.php',
    data: {
      type: 'ship-order',
      orderID: orderID,
    },
    success: (result) => {
      result = JSON.parse(result);

      if (result) {
        const modal = new StatusModal('Order successfully marked as shipped!');
        modal.show();
        modal.dismissAfter(500);
        window.location.reload();
      }
    },
  });
}
