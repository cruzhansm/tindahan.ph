import { Pagination } from '../../common/pagination.js';
import { retrieveAllStoreOrders } from '../db-methods/retrieve.js';
import { confirmOrder, shipOrder } from '../db-methods/update.js';

var ORDERS = new Array();

window.onload = async () => {
  const orders = JSON.parse(await retrieveAllStoreOrders());

  console.log(orders);
  ORDERS = sortOrders(orders);
  appendAllOrders(ORDERS);
  attachFilterListeners();
};

function sortOrders(orders) {
  const customers = [...new Set(orders.map((order) => order.customer))];

  let sorted = new Array();

  // SORT BY CUSTOMER
  customers.forEach((customer) => {
    let temp = orders.filter((order) => order.customer == customer);

    let byOrder = [...new Set(temp.map((o) => o.order_id))];

    // SORT BY ORDER
    byOrder.forEach((orderID) => {
      sorted.push(temp.filter((order) => order.order_id == orderID));
    });
  });

  return sorted;
}

function appendAllOrders(orders) {
  const pagination = new Pagination(
    'paginationContainer',
    orders.length / 3,
    orders.length > 0 ? true : false
  );

  let limit = 3;
  let idx = 0;

  for (let currentPage = 0; currentPage < pagination.pageTotal; currentPage++) {
    let target = document.querySelector(`#page${currentPage + 1}`);

    for (let num = 1; num <= limit && idx < orders.length; num++) {
      let customer = orders[idx++];

      let customerOrders = document.createElement('div');
      customerOrders.classList.add('orders-group');

      customerOrders.innerHTML += `
      <div class="order-header">
        <div class="order-header-details">
          <div class="fs-18">${customer[0].customer}</div>
          <div class="order-header-count">Order#${customer[0].order_id}</div>
        </div>
        <div class="order-header-price">P${customer
          .map((p) => parseInt(p.order_price))
          .reduce((x, y) => (x += y))}</div>
      </div>
    `;

      let orderGroup = document.createElement('div');
      orderGroup.classList.add('order-product-group');

      customer.forEach((order) => {
        let orderContainer = document.createElement('div');
        orderContainer.classList.add('order-product');

        orderContainer.innerHTML += `
          <div class="order-product-details">
            <img
              src="${order.product_img}"
              class="order-product-img"
            ></img>
            <div class="order-product-info">
              <div class="order-product-name">${order.product_name}</div>
              <div class="order-product-variation">${order.variation}</div>
              <div class="order-product-quantity">x${order.order_quantity}</div>
            </div>
          </div>
          <div>P${order.order_price}</div>
      `;

        orderGroup.append(orderContainer);
      });

      let status = document.createElement('div');
      status.innerHTML = `
      <div class="order-status-list ms-auto">
        ${determineStatus(customer[0].order_status, customer[0].order_id)}
      </div>
    `;

      customerOrders.append(orderGroup);
      customerOrders.append(status);
      target.append(customerOrders);
    }
  }
}

function determineStatus(status, orderID) {
  let ret = new String();

  switch (status) {
    case 'confirmation':
      ret = `
        <div>This order is awaiting your confirmation.</div>
        <button class="btn btn-primary" onclick="confirmSpecifiedOrder(${orderID})">Confirm order</button>
      `;
      break;
    case 'processing':
      ret = `
        <div>Awaiting for you to package and ship the order.</div>
        <button class="btn btn-primary" onclick="shipSpecifiedOrder(${orderID})">Mark as Shipped</button>
      `;
      break;
    case 'shipped':
      ret = `
          <div>Your package is en route to our sort center</div>
          <div class="order-product-status active">SHIPPED</div>
        `;
      break;
    case 'transit':
      ret = `
          <div>Your package is on its way to the recipient.</div>
          <div class="order-product-status active">TRANSIT</div>
        `;
      break;
    case 'delivered':
      ret = `
          <div>Your package has been successfully received by the recipient.</div>
          <div class="order-product-status rate">DELIVERED</div>
        `;
      break;
    case 'cancelled':
      ret = `
          <div>The customer has cancelled this order.</div>
          <div class="order-product-status">CANCELLED</div>
        `;
      break;
  }
  return ret;
}

function attachFilterListeners() {
  const radios = Array.from(document.querySelector('.orders-filters').elements);

  radios.forEach((radio) => {
    radio.addEventListener('change', () => {
      filter(radio.value);
    });
  });
}

function filter(status) {
  const target = document.querySelector('.container-orders-list');

  let filtered =
    status != 'all'
      ? ORDERS.filter(
          (o) => o.filter((g) => g.order_status == status).length != 0
        )
      : ORDERS;

  target.innerHTML = '';
  appendAllOrders(filtered);
}

window.confirmSpecifiedOrder = function confirmSpecifiedOrder(orderID) {
  confirmOrder(orderID);
};

window.shipSpecifiedOrder = function shipSpecifiedOrder(orderID) {
  shipOrder(orderID);
};
