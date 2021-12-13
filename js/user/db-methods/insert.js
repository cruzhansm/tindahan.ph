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

export function fakeCheckoutItems(order) {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/orders/crud.php',
    data: {
      type: 'fake-checkout-cart',
      order: JSON.stringify(order),
    },
    success: (result) => {
      result = JSON.parse(result);

      window.location.href = '/tindahan.ph/src/user/user-checkout-process.php';
    },
  });
}

export async function checkoutItems(order, recipient) {
  return await $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/orders/crud.php',
    data: {
      type: 'checkout-cart-items',
      order: JSON.stringify(order),
      recipient: JSON.stringify(recipient),
    },
    success: (result) => {
      result = JSON.parse(result);

      return result;
    },
  });
}

export async function createOrderInvoice(invoice) {
  console.log(invoice);

  return await $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/orders/crud.php',
    data: {
      type: 'create-order-invoice',
      invoice: JSON.stringify(invoice),
    },
    success: (result) => {
      console.log(result);

      result = JSON.parse(result);

      return result;
    },
  });
}

export function createProductReview(review) {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/products/crud.php',
    data: {
      type: 'create-product-review',
      review: JSON.stringify(review),
    },
    success: (result) => {
      result = JSON.parse(result);
      console.log(result);

      if (result) {
        window.location.reload();
      }
    },
  });
}
