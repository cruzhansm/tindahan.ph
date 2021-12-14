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
    case 'create-listing-tabs':
      echo json_encode(createListingTabs()); break;
    case 'suspend-listing':
      echo json_encode(suspendListing()); break;
  }

  function getSpecificProduct() {
    include('product.php');
    include('../connect.php');
    include('../error.php');

    $product_id = (int)$_REQUEST['productID'];

    $product = Product::checkIfExists($product_id) ? new Product($product_id) : null;

    return $product != null ? $product->jsonSerialize() : new CustomError('Product not found!', 'The specific product could not be found. It might have been deleted, renamed, or relocated.');
  }

  function addProductToCart() {
    include('../error.php');
    include('../cart/cart.php');

    $product = $_REQUEST['product'];

    $cart = new Cart($_SESSION['user_id']);
    
    return $cart->add($product) == true ? true : new CustomError('Add to cart', 'Could not add product to cart.');
  }

  function createProductReview() {
    include('product.php');

    $review = json_decode($_REQUEST['review'], MYSQLI_ASSOC);

    $product = new Product($review['productID']);
    $success = $product->addReview($review, $_SESSION['user_id']);

    return $success;
  }

  function createListingTabs() {
    include('../connect.php');

    $listings = array();

    $listingInfo = "SELECT *
                    FROM products p
                    WHERE p.active = 'true'";

    $query = mysqli_query($conn, $listingInfo);

    if (mysqli_num_rows($query) > 0) {
      while ($data = mysqli_fetch_assoc($query)) {
        $listing_details = array();
        $listing_details['products'] = $data;
        $listing_details['store'] = getStoreInfo($data['product_store']);

        array_push($listings, $listing_details);
      }
    }
    return $listings;
  }

  function getStoreInfo($storeId) {
    include('../connect.php');

    $storeNames = array();
    $selectStore = "SELECT store_name
                    FROM partner_store
                    WHERE store_id = $storeId";

    $query = mysqli_query($conn, $selectStore);

    if (mysqli_num_rows($query) > 0) {
      while ($data = mysqli_fetch_assoc($query)) {
        array_push($storeNames, $data['store_name']);
      }
    }
    return $storeNames;
  }

  function suspendListing() {
    include('../connect.php');
    include('../product.php');

    $listings = array();
    $product = array();
    $listings = $_REQUEST['listing'];
    $product = $listings['products'];

    $result = Product::changeSuspensionStatus($product['product_id'], 'true');

    return $result == true ? true : false;
  }
?>