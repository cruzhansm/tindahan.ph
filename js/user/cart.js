var USER_CART;

function initCart() {

  // DO BACKEND, GET USER_ID
  USER_CART = new Cart(1);
  USER_CART.createCart();
}