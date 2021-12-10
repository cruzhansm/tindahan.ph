<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'checkout-cart-items':
      echo json_encode(checkoutCartItems()); break;
  }

  function checkoutCartItems() {
    include('order.php');
    include('../error.php');
    $order = json_decode($_REQUEST['order'], MYSQLI_ASSOC);

    $result = Order::newOrder($order);

    return $result == true ? true : new CustomError(error: 'No items selected', error_msg: 'Please select items to checkout first!');
  }
?>