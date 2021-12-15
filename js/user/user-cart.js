import { StatusModal } from '../common/modal/status-modal.js';
import { Cart, CartProduct } from './cart.js';
import { fakeCheckoutItems } from './db-methods/insert.js';
import { retrieveCartItems } from './db-methods/retrieve.js';

window.onload = async () => {
  let data = JSON.parse(await retrieveCartItems());

  console.log(data);

  const cart = new Cart(data.store_owner, data.cart_items);
  appendStores(cart.byStore);
  appendSelectAllListener();
  appendQuantityListeners();
};

function appendStores(stores) {
  const target = document.querySelector('.container-form');

  stores.forEach((s) => target.append(s));
}

function appendSelectAllListener() {
  const select = document.querySelector('#selectAll');
  const stores = Array.from(
    document.querySelectorAll('.form-check > input[type=checkbox]')
  ).filter((c) => c.id != 'selectAll');

  select.addEventListener('change', () => {
    const label = select.nextElementSibling;

    label.innerText = select.checked ? 'Unselect All' : 'Select All';

    stores.forEach((store) => {
      if (store.checked == false && select.checked == true) {
        store.click();
      }

      if (select.checked == false) {
        store.click();
      }
    });
  });
}

function appendQuantityListeners() {
  const products = Array.from(document.querySelectorAll('.cart-product-group'));

  products.forEach((product) => {
    CartProduct.attachQuantityChangeListeners(product);
  });
}

window.showModal = function showModal(selectedModal, productID) {
  const modal = new bootstrap.Modal(selectedModal);
  const del = modal._element.querySelector('#delete');

  del.addEventListener('click', () => {
    Cart.removeFromCart(productID).then((resolve) => {
      if (resolve == true) {
        try {
          const tbd = document.querySelector(`#prod${productID}`);
          const parent = tbd.parentElement;
          const ancestor = tbd.parentElement.parentElement;

          dismissModal(selectedModal);

          tbd.remove();

          if (parent.childNodes.length == 0) {
            ancestor.remove();
          }

          Cart.updateTotalPrice();
        } catch (err) {
          console.log(err);
        }
      }
    });
  });

  modal.show();
};

window.dismissModal = function dismissModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const del = modal._element.querySelector('#delete');

  del.removeEventListener('click', showModal, true);

  modal.hide();
};

window.attemptCheckout = function attemptCheckout() {
  let checkout = Array.from(
    document.querySelectorAll(
      '.cart-product-select > input[type=checkbox]:checked'
    )
  );

  let order = {
    products: new Array(),
    totalPrice: parseInt(
      document.querySelector('#totalCart').innerText.slice(1)
    ),
  };

  checkout.forEach((p) => {
    const product = {
      cartItemID: parseInt(p.value),
      orderQuantity: parseInt(document.querySelector(`#q${p.value}`).innerText),
      orderPrice: parseInt(
        document
          .querySelector(`#q${p.value}`)
          .parentElement.nextElementSibling.innerText.slice(1)
      ),
    };

    order.products.push(product);
  });

  console.log(order);

  if (order.products.length == 0) {
    const status = new StatusModal(
      `You can't proceed to checkout without selecting items to checkout.`
    );
    status.show();
    status.dismissAfter(1000);
  } else {
    fakeCheckoutItems(order);
  }
};
