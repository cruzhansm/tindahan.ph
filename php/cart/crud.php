<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'get-cart-items':
      echo json_encode(getCartItems()); break;
    case 'remove-from-cart':
      echo json_encode(removeFromCart()); break;
  }


  function getCartItems() {
    include('cart.php');

    $cart = new Cart($_SESSION['user_id']);

    return $cart;
  }

  function removeFromCart() {
    include('./cart.php');

    $cart_item_id = $_REQUEST['cartItemID'];

    $cart = new Cart($_SESSION['user_id']);
    $result = $cart->remove($cart_item_id);

    return $result;
  }
?>