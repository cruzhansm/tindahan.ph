var USER_CART;

function initCart() {

  // DO BACKEND, GET USER_ID
  USER_CART = new Cart(1);
  USER_CART.createCart();

  // GRAB SELECT ALL CHECKBOX AND DEFINE BEHAVIOR
  let selectAll = document.querySelector('#selectAll');
  initSelectAll(selectAll);

  // GRAB ALL STORE LEVEL CHECKBOXES AND DEFINE BEHAVIOR
  let selectStores = Array.from(document.querySelectorAll('.form-check'))
                     .map((form) => { return form.firstElementChild; });
  selectStores.splice(0, 1);
  initSelectStores(selectStores);

  // GRAB ALL PRODUCT LEVEL CHECKBOXES AND DEFINE BEHAVIOR
  let selectProducts = document.querySelectorAll('.form-check-input:not([id])');
  initSelectProducts(selectProducts);

  // // GRAB ALL TOTAL PRICES, SUM IT, THEN INITIALIZE TOTAL CHECKOUT PRICE
  

  // console.log(totalPrice);

  // initTotalCheckoutPrice(totalPrice);
}

function initSelectAll(checkbox) {

  checkbox.addEventListener('change', () => {
    let allCheckboxes = document.querySelectorAll('.form-check-input');
    let label = checkbox.nextElementSibling;

    allCheckboxes = Array.from(allCheckboxes);
    allCheckboxes.splice(0, 1);

    allCheckboxes.forEach((checkboxes) => { 
      modifyCurrentState(checkbox, checkboxes);
    });

    label.innerText = (label.innerText == 'Select all') ? 'Unselect all' :
                                                          'Select all';

    USER_CART.updateTotalPrice(USER_CART.getTotalPrice());
  });
}

function initSelectStores(storeCheckboxes) {

  let selectAll = document.querySelector('#selectAll');

  storeCheckboxes.forEach((storeCheckbox) => {
    storeCheckbox.addEventListener('change', () => {
      let productCheckboxes = storeCheckbox.parentElement.parentElement
                              .parentElement.nextElementSibling
                              .querySelectorAll('.form-check-input');

      if(storeCheckbox.checked == false && selectAll.checked == true) {
        selectAll.checked = false;
        selectAll.nextElementSibling.innerText = 'Select all';
      }
      
      if(storeCheckbox.checked == true && selectAll.checked == false) {
        if(storeCheckboxes.every((checkbox) => { return checkbox.checked; })) {
          selectAll.click();
        }
      }

      productCheckboxes.forEach((checkbox) => {
        modifyCurrentState(storeCheckbox, checkbox);
      });

      USER_CART.updateTotalPrice(USER_CART.getTotalPrice());
    });
  });
}

function initSelectProducts(productCheckboxes) {

  let selectAll = document.querySelector('#selectAll');

  productCheckboxes.forEach((productCheckbox) => {
    productCheckbox.addEventListener('change', () => {
      let storeCheckbox = productCheckbox.parentElement.parentElement
                          .parentElement.parentElement.previousElementSibling
                          .querySelector('.form-check-input');
      
      // IF A PRODUCT IS UNCHECKED, UNCHECK THE STORE
      if(productCheckbox.checked == false && storeCheckbox.checked == true) {
        storeCheckbox.checked = false;
        selectAll.checked = false;
        selectAll.nextElementSibling.innerText = 'Select all';
      }
      // IF ALL PRODUCTS ARE INDIVIDUALLY CHECKED, CHECK THE STORE
      if(productCheckbox.checked == true && storeCheckbox.checked == false) {
        let recheck = Array.from(productCheckbox.parentElement
                                 .parentElement.parentElement.parentElement
                                 .querySelectorAll('.form-check-input'));

        if(recheck.every((checkbox) => { return checkbox.checked })) {
          storeCheckbox.click();
        }
      }

      USER_CART.updateTotalPrice(USER_CART.getTotalPrice());
    });
  })
}

function setTotalCheckoutPrice(price) {

  let priceArea = document.querySelector('.cart-checkout-total')
                          .lastElementChild;

  priceArea.innerText = `P ${price}`;
  
  USER_CART.checkoutPrice = parseInt(price);
}

// PRESERVE CHECKBOX STATE IF ALREADY CHECKED, ELSE CHECK IT
function modifyCurrentState(origin, target) {

  if(origin.checked === true && target.checked === false ||
     origin.checked === false && target.checked === true) {
    target.click();
  }
}

function checkoutCart() {

  USER_CART.checkout();

  let checkout = document.querySelector('.checkout-area');
  checkout.innerHTML = `<div>Temporary Checkout Area</div>`;

  if(USER_CART.checkoutProducts.length > 0) {
    let currentStore = USER_CART.checkoutProducts[0].store;
    
    USER_CART.checkoutProducts.forEach((product, index) => {
      if(currentStore == product.store) {
        checkout.innerHTML += `
          <br>
          <span>Store ${product.store}<span>
          <div>
        `
        currentStore = product.store + 1;
      }
      
      checkout.innerHTML += `
        <br>
        <div>
          <div>Product: ${product.name}</div>
          <div>Quantity: ${product.quantity}</div>
          <div>Total: ${product.quantity * product.price}</div>
        </div>
      `
    });
  }
}