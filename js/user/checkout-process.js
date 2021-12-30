import {
  attachEmptyFieldListeners,
  disableSubmitBtn,
  noSubmit,
  removeAllValidation,
  resetFlags,
  stripInputListeners,
} from '../../js/common/input/form.js';
import {
  retrieveActiveVouchers,
  retrieveCurrentActiveOrder,
  retrieveUserAddress,
} from './db-methods/retrieve.js';
import { StatusModal } from '../common/modal/status-modal.js';
import { checkoutItems, createOrderInvoice } from './db-methods/insert.js';

var ORDER_DETAILS = {
  order: new Object(),
  recipient: {
    recipientName: new String(),
    recipientContact: new Number(),
    recipientAddress: new String(),
  },
  recipientIndiv: new Object(),
  invoice: new Object(),
};

var INVOICE = {
  paymentMethod: new String(),
  amountToPay: new Number(),
  amountPaid: 0,
};

var VOUCHERS = new Array();
var VOUCHER_APPLIED = false;

var ORIG_DETAILS = new Object();
var ORDER_OWNER = new Number();
var DELIVERY_FEE = 50.0;

window.onload = async () => {
  const recipient = JSON.parse(await retrieveUserAddress());
  const form = document.querySelector('#checkoutInfo');

  ORDER_OWNER = recipient.user_address.user_id;

  // console.log(recipient);

  appendUserDetails(recipient);
  prepareForm(form);
};

function prepareForm(form) {
  disableSubmitBtn(form)
    .then(attachEmptyFieldListeners('input'))
    .then(attachEmptyFieldListeners('number'));
}

function appendUserDetails(recipient) {
  const recipientFname = document.querySelector('#recipientFname');
  const recipientLname = document.querySelector('#recipientLname');
  const recipientContact = document.querySelector('#recipientContact');
  const recipientStreet = document.querySelector('#recipientStreet');
  const recipientCity = document.querySelector('#recipientCity');
  const recipientBrgy = document.querySelector('#recipientBrgy');
  const recipientLandmark = document.querySelector('#recipientLandmark');
  const recipientZipcode = document.querySelector('#recipientZipcode');

  recipientFname.value = recipient.user_fname;
  recipientLname.value = recipient.user_lname;
  recipientContact.value = recipient.user_contact;

  if (recipient.user_address.user_id != null) {
    recipientStreet.value = recipient.user_address.user_street;
    recipientCity.value = recipient.user_address.user_city;
    recipientBrgy.value = recipient.user_address.user_barangay;
    recipientLandmark.value = recipient.user_address.user_landmark;
    recipientZipcode.value = recipient.user_address.user_zipcode;
  }
}

window.proceedToSummary = function proceedToSummary(event) {
  noSubmit(event);

  const form = document.querySelector('#checkoutInfo');
  const data = form.elements;

  const recipientAddress = {
    recipientStreet: data[3].value,
    recipientBrgy: data[4].value + ', ' + data[5].value,
    recipientZipcode: parseInt(data[7].value),
    recipientLandmark: data[6].value,
  };

  ORIG_DETAILS = {
    user_fname: data[0].value,
    user_lname: data[1].value,
    user_contact: data[2].value,
    user_address: {
      user_id: ORDER_OWNER,
      user_barangay: data[5].value,
      user_city: data[4].value,
      user_landmark: data[6].value,
      user_street: data[3].value,
      user_zipcode: parseInt(data[7].value),
    },
  };

  const finalAddress = Object.values(recipientAddress).reduce(
    (x, y) => (x += '\n' + y)
  );

  console.log(finalAddress);
  ORDER_DETAILS.recipient.recipientName = data[0].value + ' ' + data[1].value;
  ORDER_DETAILS.recipient.recipientContact = parseInt(data[2].value);
  ORDER_DETAILS.recipient.recipientAddress = finalAddress;
  ORDER_DETAILS.recipientIndiv = recipientAddress;

  const voucher = document.querySelector('#orderVoucher');

  resetFlags()
    .then(stripInputListeners(form))
    .then(removeAllValidation(form))
    .then(nextStep())
    .then(initializeOrderSummary())
    .catch((error) => console.log(error));
};

window.redirectPreviousURL = function redirectPreviousURL() {
  window.history.back();
};

function nextStep() {
  let oldActive = Array.from(
    document.querySelectorAll('.container-checkout-process')
  ).filter((c) => !c.classList.contains('visually-hidden'));
  oldActive = oldActive[oldActive.length - 1];
  const newActive = oldActive.nextElementSibling;
  const processes = Array.from(
    document.querySelectorAll('.checkout-progress-step')
  ).reverse();
  const activeProcess = processes.findIndex((process) =>
    process.classList.contains('done')
  );

  oldActive.classList.add('visually-hidden');
  newActive.classList.remove('visually-hidden');
  processes[activeProcess - 1].classList.add('done');
}

function previousStep() {
  let oldActive = Array.from(
    document.querySelectorAll('.container-checkout-process')
  ).filter((c) => !c.classList.contains('visually-hidden'));
  oldActive = oldActive[oldActive.length - 1];
  const newActive = oldActive.previousElementSibling;
  const processes = Array.from(
    document.querySelectorAll('.checkout-progress-step')
  ).reverse();
  const activeProcess = processes.findIndex((process) =>
    process.classList.contains('done')
  );

  oldActive.classList.add('visually-hidden');
  newActive.classList.remove('visually-hidden');
  processes[activeProcess].classList.remove('done');
}

async function initializeOrderSummary() {
  const order = JSON.parse(await retrieveCurrentActiveOrder());
  const vouchers = JSON.parse(await retrieveActiveVouchers());

  ORDER_DETAILS.order = order;

  // console.log(order);
  // console.log(vouchers);

  VOUCHERS = vouchers;

  console.log(order);

  const stores = [
    ...new Set(
      order.products.map((products) => products.order_details.store_name)
    ),
  ];

  let ordered = new Array();

  stores.forEach((store) => {
    ordered.push(
      order.products.filter(
        (product) => product.order_details.store_name == store
      )
    );
  });

  appendOrderItems(ordered);
}

function appendOrderItems(ordered) {
  const target = document.querySelector('.orders-group');
  const subtotal = document.querySelector('#orderSubtotal');
  const delivery = document.querySelector('#orderDelivery');
  const total = document.querySelector('#orderTotalPrice');
  let totalPrice = new Number();
  let productCount = new Number();

  ordered.forEach((store) => {
    target.innerHTML += `
      <div class="order-header">
        <div class="order-header-details">
          <div class="fs-18">${store[0].order_details.store_name}</div>
        </div>
      </div>
    `;

    let productGroup = document.createElement('div');
    let price = new Number();

    productGroup.classList.add('order-product-group');

    store.forEach((product) => {
      productCount++;
      price += product.orderPrice;
      productGroup.innerHTML += `
        <div class="order-product">
          <div class="order-product-details">
            <img src="${product.order_details.product_img}" class="order-product-img" />
            <div class="order-product-info">
              <div class="order-product-name">${product.order_details.product_name}</div>
              <div class="order-product-variation">${product.order_details.variation}</div>
              <div class="order-product-quantity">x${product.orderQuantity}</div>
            </div>
          </div>
          <div>P${product.orderPrice}</div>
        </div>
      `;
      target.append(productGroup);
    });

    let storePrice = document.createElement('div');
    storePrice.classList.add('order-product-price');
    storePrice.innerHTML = `<span>P${price}</span>`;

    totalPrice += price;

    target.append(storePrice);
  });

  subtotal.innerText = `P${totalPrice}`;
  delivery.innerText = `P${productCount * DELIVERY_FEE}`;
  if (total.innerText.length == 0) {
    total.innerText = `P${totalPrice + productCount * DELIVERY_FEE}`;
  }
}

window.verifyValidVoucher = function verifyValidVoucher() {
  const voucherInput = document.querySelector('#orderVoucher');

  const isValidVoucher = VOUCHERS.find(
    (voucher) => voucher.voucher_code.localeCompare(voucherInput.value) == 0
  );

  if (isValidVoucher != undefined && VOUCHER_APPLIED === false) {
    const statusModal = new StatusModal('Voucher applied!');
    const voucherOff = document.querySelector('#orderVoucherOff');
    const totalPrice = document.querySelector('#orderTotalPrice');
    const price = parseInt(totalPrice.innerText.slice(1));

    voucherOff.innerText =
      isValidVoucher.voucher_type == 'percent'
        ? `-P${(parseInt(isValidVoucher.voucher_discount) / 100) * price}`
        : `-P${parseInt(isValidVoucher.voucher_discount)}`;

    totalPrice.innerText = `P${
      price - parseInt(voucherOff.innerText.slice(2))
    }`;

    if (voucherInput.parentElement.querySelector('.invalid-feedback') != null) {
      voucherInput.classList.remove('is-invalid');
      voucherInput.parentElement.querySelector('.invalid-feedback').remove();
    }

    voucherInput.classList.add('is-valid');

    statusModal.show();
    statusModal.dismissAfter(500);
    VOUCHER_APPLIED = true;
  } else if (VOUCHER_APPLIED == true) {
    const statusModal = new StatusModal('A voucher has already been applied!');
    statusModal.show();
    statusModal.dismissAfter(500);
  } else {
    const error = document.createElement('div');
    error.classList.add('invalid-feedback');
    error.innerText = 'Invalid voucher entered.';

    voucherInput.classList.remove('is-valid');

    if (voucherInput.parentElement.querySelector('.invalid-feedback') == null) {
      voucherInput.classList.add('is-invalid');
      voucherInput.parentElement.append(error);
    }
  }
};

window.proceedToInformation = function proceedToInformation() {
  const form = document.querySelector('#checkoutInfo');
  const ordersGroup = document.querySelector('.orders-group');

  appendUserDetails(ORIG_DETAILS);
  prepareForm(form);
  ordersGroup.innerHTML = '';
  previousStep();
};

window.proceedBackToSummary = function proceedBackToSummary() {
  const form = document.querySelector('#payment');
  const ccform = document.querySelector('.checkout-process-payment');
  const buttons = ccform.parentElement.querySelector('.container-button-group');

  ccform.classList.add('visually-hidden');
  buttons.classList.remove('cc');
  buttons.lastElementChild.classList.remove('tph-disabled');

  resetFlags()
    .then(stripInputListeners(form))
    .then(removeAllValidation(form))
    .then(previousStep())
    .then(initializeOrderSummary())
    .catch((error) => console.log(error));
};

window.proceedToPayment = function proceedToPayment() {
  const ordersGroup = document.querySelector('.orders-group');
  const form = document.querySelector('#payment');
  const radios = Array.from(form.querySelectorAll('input[type=radio]'));
  const ccform = document.querySelector('.checkout-process-payment');
  const buttons = form.querySelector('.container-button-group');

  console.log(radios);

  INVOICE.amountToPay = parseInt(
    document.querySelector('#orderTotalPrice').innerText.slice(1)
  );

  nextStep();
  ordersGroup.innerHTML = '';

  radios.forEach((radio) => {
    radio.addEventListener('change', () => {
      if (radios[1].checked) {
        ccform.classList.remove('visually-hidden');
        buttons.classList.add('cc');

        disableSubmitBtn(form)
          .then(attachEmptyFieldListeners('input'))
          .then(attachEmptyFieldListeners('number'));
      } else {
        resetFlags()
          .then(stripInputListeners(form))
          .then(removeAllValidation(form));
        buttons.lastElementChild.classList.remove('tph-disabled');

        ccform.classList.add('visually-hidden');
        buttons.classList.remove('cc');
      }
    });
  });
};

window.proceedToFinalStep = async function proceedToFinalStep(event) {
  noSubmit(event);

  const paymentMethod = document
    .querySelector('#payment')
    .querySelector('input[type=radio]:checked').id;

  if (paymentMethod == 'cc') {
    INVOICE.paymentMethod = 'card';
    INVOICE.amountPaid = INVOICE.amountToPay;
  } else {
    INVOICE.paymentMethod = 'cod';
  }

  ORDER_DETAILS.invoice = INVOICE;
  console.log(ORDER_DETAILS);

  const success = JSON.parse(
    await checkoutItems(ORDER_DETAILS.order, ORDER_DETAILS.recipient)
  );

  if (success) {
    const done = JSON.parse(await createOrderInvoice(ORDER_DETAILS.invoice));

    if (done) {
      nextStep();
    }
  }
};
