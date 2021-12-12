<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'fake-checkout-cart':
      echo json_encode(fakeCheckoutCart()); break;
    case 'checkout-cart-items':
      echo json_encode(checkoutCartItems()); break;
    case 'retrieve-current-order':
      echo json_encode(retrieveCurrentOrder()); break;
    case 'retrieve-active-vouchers':
      echo json_encode(retrieveActiveVouchers()); break;
    case 'create-order-invoice':
      echo json_encode(createOrderInvoice()); break;
  }

  function fakeCheckoutCart() {
    $_SESSION['pending-order'] = json_decode($_REQUEST['order']);

    return $_SESSION['pending-order'];
  }

  function checkoutCartItems() {
    include('order.php');
    include('../error.php');
    include('../cart/cart.php');
    
    $order = json_decode($_REQUEST['order'], MYSQLI_ASSOC);
    $recipient = json_decode($_REQUEST['recipient'], MYSQLI_ASSOC);

    $result = Order::newOrder($_SESSION['user_id'], $order, $recipient);

    $cart_items = array();

    foreach($order['products'] as $product) {
      array_push($cart_items, $product['cartItemID']);
    }

    $cart = new Cart($_SESSION['user_id']);
    $cart->order($cart_items);

    return $result == true ? true : new CustomError(error: 'No items selected', error_msg: 'Please select items to checkout first!');
  }

  function createOrderInvoice() {
    include('invoice.php');
    include('order.php');

    $invoice = json_decode($_REQUEST['invoice'], MYSQLI_ASSOC);

    $order_id = Order::getLatestOrder($_SESSION['user_id']);
    $result = Invoice::create($invoice, $order_id);

    if($result == true) {
      unset($_SESSION['pending-order']);
    }

    return $result;
  }

  function retrieveCurrentOrder() {
    include('order.php');

    $order = $_SESSION['pending-order'];
    $products = $order->products;

    for($i = 0; $i < count($products); $i++) {
      $order->products[$i]->order_details = Order::fetchFakeOrderDetails($order->products[$i]->cartItemID);
    }

    return $order;
  }

  function retrieveActiveVouchers() {
    include('voucher.php');

    $vouchers = Voucher::fetchAllActiveVouchers();

    return $vouchers != false ? $vouchers : false;
  }
?>