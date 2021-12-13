import { retrieveAllPurchases } from './db-methods/retrieve.js';
import { cancelSpecifiedOrder } from './db-methods/update.js';
import { noSubmit } from '../common/input/form.js';
import { attachCharCountListener } from '../common/input/input.js';
import { createProductReview } from './db-methods/insert.js';
import { Pagination } from '../common/pagination.js';

var PURCHASES = new Array();

window.onload = async () => {
  const purchases = JSON.parse(await retrieveAllPurchases());
  const ordered = purchases.map((purchase) => {
    return {
      orderID: purchase.invoice.order_id,
      toPay: purchase.invoice.amount_to_pay,
      hasPaid: parseInt(purchase.invoice.amount_paid) > 0 ? true : false,
      orders: {
        orders: purchase.order.order_products,
        orderStatus: purchase.order.order_status,
        orderStatusMsg: purchase.order.order_status_msg,
      },
    };
  });

  console.log(ordered);

  PURCHASES = ordered;

  appendAllPurchases(ordered);
  attachFilterListeners();
};

function appendAllPurchases(ordered) {
  const pagination = new Pagination(
    'paginationContainer',
    ordered.length / 3,
    ordered.length > 0 ? true : false
  );

  let limit = 3;
  let idx = 0;

  for (let currentPage = 0; currentPage < pagination.pageTotal; currentPage++) {
    let target = document.querySelector(`#page${currentPage + 1}`);

    for (let num = 1; num <= limit && idx < ordered.length; num++) {
      let order = ordered[idx++];
      let ordersGroup = document.createElement('div');
      ordersGroup.classList.add('orders-group');
      ordersGroup.setAttribute('id', `og${order.orderID}`);

      ordersGroup.innerHTML = `
      <div class="order-header">
        <div class="order-header-details">
          <div class="fs-18">Order#${order.orderID}</div>
        </div>
        <div class="order-header-price">P${order.toPay}</div>
      </div>
      `;

      let productGroup = document.createElement('div');
      productGroup.classList.add('order-product-group');

      order.orders.orders.forEach((product) => {
        productGroup.innerHTML += `
        <div class="order-product purchases">
          <div class="order-product-details">
          <i class="fa-solid fa-comment-dots ${
            order.orders.orderStatus != 'delivered' ? 'tph-disabled' : ''
          }" onclick="attemptProductReview(productReview, ${
          product.product_id
        }, ${product.order_product_id})" style="${
          product.review_id != null
            ? 'color: var(--tph-highlight); pointer-events: none;'
            : ''
        }"></i>
            <img src="${product.product_img}" class="order-product-img" />
            <div class="order-product-info">
              <div class="order-product-name">${product.product_name}</div>
              <div class="order-product-variation">${product.variation}</div>
              <div class="order-product-quantity">x${
                product.order_quantity
              }</div>
            </div>
          </div>
          <div>P${product.order_price}</div>
        </div>
        `;
      });

      let orderStatus = document.createElement('div');
      orderStatus.classList.add('order-status-list');

      orderStatus.innerHTML = `
        <div class="order-product-status deliver">
          ${
            order.orders.orderStatusMsg == null
              ? ''
              : order.orders.orderStatusMsg
          }
        </div>
        <div class="order-product-status ${
          order.orders.orderStatus != 'cancelled'
            ? order.orders.orderStatus != 'delivered'
              ? 'active'
              : 'rate'
            : 'cancelled'
        }">${order.orders.orderStatus}</div>
        ${
          ['confirmation', 'processing'].includes(order.orders.orderStatus)
            ? `<button class="btn btn-tertiary order-product-status" onclick="attemptCancelOrder(orderCancel, ${order.orderID})"> Cancel </button>`
            : ''
        }
      `;

      ordersGroup.append(productGroup, orderStatus);
      target.append(ordersGroup);
    }
  }
}

window.attemptCancelOrder = function attemptCancelOrder(
  selectedModal,
  orderID
) {
  const modal = new bootstrap.Modal(selectedModal);
  const footer = selectedModal.querySelector('.modal-footer');

  footer.innerHTML = `
    <button id="delete" type="button" class="btn btn-highlight" onclick="cancelOrder(${orderID}, orderCancel)">
      Yes
    </button>
    <button
      id="cancel"
      type="button"
      class="btn modal-cancel-btn remove-product"
      data-bs-dismiss="modal"
      onclick="dismissModal(orderCancel)"
    >
      No
    </button>
  `;

  modal.show();
};

window.dismissModal = function dismissModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const form = selectedModal.querySelector('form');

  modal.hide();
};

window.cancelOrder = async function cancelOrder(orderID, selectedModal) {
  const cancelled = JSON.parse(await cancelSpecifiedOrder(orderID));

  if (cancelled) {
    dismissModal(selectedModal);
    window.location.reload();
  }
};

function attachFilterListeners() {
  const radios = document.querySelector('.orders-filters').elements;

  Array.from(radios).forEach((radio) => {
    radio.addEventListener('change', () => {
      filter(radio.id);
    });
  });
}

function filter(status) {
  const paginationPages = document.querySelector('#paginationPages');
  const paginationController = document.querySelector('#paginationContainer');

  const filtered =
    status != 'all'
      ? PURCHASES.filter((purchase) => purchase.orders.orderStatus == status)
      : PURCHASES;

  console.log(filtered);

  paginationPages.innerHTML = '';
  paginationController.innerHTML = '';
  appendAllPurchases(filtered);
}

window.attemptProductReview = function attemptProductReview(
  selectedModal,
  productID,
  orderProductID
) {
  const modal = new bootstrap.Modal(selectedModal);
  const footer = selectedModal.querySelector('.modal-footer');
  const form = selectedModal.querySelector('form');

  attachCharCountListener(
    form.querySelector(`#productReviewMsg`),
    form.querySelector(`#productReviewMsgCount`)
  );

  footer.innerHTML = `
    <button
      type="button"
      class="btn btn-tertiary"
      onclick="dismissModal(productReview)"
    >
      Cancel
    </button>
    <button type="button" class="btn btn-primary" onclick="reviewProduct(event, ${productID}, ${orderProductID})">Submit</button>
  `;

  modal.show();
};

window.reviewProduct = async function reviewProduct(
  event,
  productID,
  orderProductID
) {
  noSubmit(event);

  const images = Array.from(document.querySelector('#reviewImages').files).map(
    (img) => `/tindahan.ph/assets/mock/product-reviews/${img.name}`
  );

  const review = {
    productID: productID,
    orderProduct: orderProductID,
    rating: document.querySelector('#productRatingSelect').value,
    review: document.querySelector('#productReviewMsg').value,
    reviewImgs: images,
  };

  createProductReview(review);
};
