<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'retrieve-product':
      echo json_encode(getSpecificProduct()); break;
    case 'add-to-cart':
      echo json_encode(addProductToCart()); break;
    case 'create-product-review':
      echo json_encode(createProductReview()); break;
  }

  function getSpecificProduct() {
    include('product.php');
    include('../connect.php');
    include('../error.php');

    $product_id = (int)$_REQUEST['productID'];

    $product = Product::checkIfExists($product_id) ? new Product($product_id) : null;

    return $product != null ? $product->jsonSerialize() : new CustomError(error: 'Product not found!', error_msg: 'The specific product could not be found. It might have been deleted, renamed, or relocated.');
  }

  function addProductToCart() {
    include('../error.php');
    include('../cart/cart.php');

    $product = $_REQUEST['product'];

    $cart = new Cart($_SESSION['user_id']);
    
    return $cart->add($product) == true ? true : new CustomError(error: 'Add to cart', error_msg: 'Could not add product to cart.');
  }

  function createProductReview() {
    include('product.php');

    $review = json_decode($_REQUEST['review'], MYSQLI_ASSOC);

    $product = new Product($review['productID']);
    $success = $product->addReview($review, $_SESSION['user_id']);

    return $success;
  }
?>