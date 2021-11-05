var CURRENT_STORE;
var CURRENT_PRODUCT;

function updateProduct(operation, store, product) {

  // PREPARATION TO UPDATE DATA
  let sindex = CURRENT_STORE = store - 1;
  let pindex = CURRENT_PRODUCT = product - 1;
  let target = USER_CART.cartStores[sindex].sproducts;
  target = target[target.findIndex(p => p.id == product)];

  // console.log(`BEFORE: Q: ${target.quantity} P: ${(target.quantity * target.price)}`);

  // GET INFO
  let storeElem = document.querySelector(`#s${store}`);
  let productElem = storeElem.querySelector(`#p${product}`);
  let quantityElem = productElem.querySelector('.cart-product-quantity')
                     .querySelector('span');
  let totalPriceElem = productElem.querySelector('.cart-product-misc')
                       .querySelectorAll('div')[2];

  let currentTotal = parseInt(totalPriceElem.innerText.toString().slice(2));
  let currentNumber = parseInt(quantityElem.innerText);

  if(operation == 1) {
    quantityElem.innerText = (--currentNumber).toString();
    totalPriceElem.innerText = `P ${(currentTotal - target.price).toString()}`;
    target.quantity--;
    
    if(currentNumber == 0) { promptProductRemoval(); }
  }
  else if(operation == 2) {
    quantityElem.innerText = (++currentNumber).toString();
    totalPriceElem.innerText = `P ${(currentTotal + target.price).toString()}`;
    target.quantity++;
  }

  USER_CART.updateTotalPrice(USER_CART.getTotalPrice());
  
  // console.log(`AFTER: Q: ${target.quantity} P: ${(target.quantity * target.price)}`);
}

function promptProductRemoval() {

  let modal = new bootstrap.Modal(document.querySelector('#productRemove'));
  modal.show();
}

function removeProduct() {

  let target = USER_CART.cartStores[CURRENT_STORE].sproducts;
  let store = document.querySelector(`#s${CURRENT_STORE + 1}`);
  let removeProduct = store.querySelector(`#p${CURRENT_PRODUCT + 1}`);

  let modal = bootstrap.Modal.getInstance(document.querySelector('#productRemove'));

  // Destroy product element
  removeProduct.remove();

  if(store.childNodes[1].childElementCount == 0) { store.remove(); }

  // Remove from cart
  target.splice(CURRENT_PRODUCT, 1);

  // Dismiss modal
  modal.hide();
}

function cancelRemoval() {

  let target = USER_CART.cartStores[CURRENT_STORE].sproducts;
  let store = document.querySelector(`#s${CURRENT_STORE + 1}`);
  let product = store.querySelector(`#p${CURRENT_PRODUCT + 1}`);
  let quantity = product.querySelector('.cart-product-quantity');
  let price = quantity.nextElementSibling;
  quantity = quantity.querySelector('span'); 

  let modal = bootstrap.Modal.getInstance(document.querySelector('#productRemove'));

  price.innerText = `P ${target[CURRENT_PRODUCT].price}`;
  quantity.innerText = (parseInt(quantity.innerText)) + 1;

  target[CURRENT_PRODUCT].quantity++;

  modal.hide();
}