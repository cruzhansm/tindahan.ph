import { StatusModal } from '../../modal/status-modal.js';

export function addToCart(product) {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/products/crud.php',
    data: {
      type: 'add-to-cart',
      product: product,
    },
    success: (result) => {
      result = JSON.parse(result);

      if (result === true) {
        const status = new StatusModal('Added to cart!');

        status.show();
        status.dismissAfter(300);
      } else {
        alert(result.error_msg);
      }
    },
  });
}
