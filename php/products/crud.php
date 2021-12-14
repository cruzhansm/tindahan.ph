<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'retrieve-product':
    case 'retrieve-single-listing':
      echo json_encode(getSpecificProduct()); break;
    case 'add-to-cart':
      echo json_encode(addProductToCart()); break;
    case 'create-product-review':
      echo json_encode(createProductReview()); break;
    case 'delete-single-variation':
      echo json_encode(deleteVariation()); break;
    case 'update-product-details':
      echo json_encode(updateProduct()); break;
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
    $success = $product->updateProductRating($review['productID']);

    return $success;
  }

  function deleteVariation() {
    include('../connect.php');

    $variation_id = $_REQUEST['variationID'];

    $query = "DELETE FROM product_variation
              WHERE variation_id = $variation_id;";

    $result = mysqli_query($conn, $query);

    return $result;
  }

  function updateProduct() {
    include('../connect.php');

    $listing = json_decode($_REQUEST['listing'], MYSQLI_ASSOC);

    $product_id = $listing['listingID'];

    $query = "UPDATE products
              SET product_name = ?, product_price = ?, product_desc = ?, product_brand = ?, product_quantity = ?
              WHERE product_id = $product_id;";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sissi',
                           $product_name,
                           $product_price, 
                           $product_desc,
                           $product_brand,
                           $product_quantity);
    
    $product_name = $listing['listingName'];
    $product_price = $listing['listingPrice'];
    $product_desc = $listing['listingDesc'];
    $product_brand = $listing['listingBrand'];
    $product_quantity = $listing['listingQuantity'];

    $result = mysqli_stmt_execute($stmt);

    $oldVariations = $listing['listingOldVariations'];

    foreach($oldVariations as $variation) {
      $variation_id = $variation['id'];

      $query2 = "UPDATE product_variation
                 SET variation = ?, price = ?, quantity = ?
                 WHERE variation_id = $variation_id;";

      $stmt = mysqli_prepare($conn, $query2);
      mysqli_stmt_bind_param($stmt, 'sii',
                             $variation_name, 
                             $variation_price,
                             $variation_quantity);
      
      $variation_name = $variation['name'];
      $variation_price = $variation['price'];
      $variation_quantity = $variation['stock'];

      $result = mysqli_stmt_execute($stmt);
    }

    $newVariations = $listing['listingNewVariations'];

    foreach($newVariations as $variation) {
      $query3 = "INSERT INTO product_variation (product_id, variation, price, quantity)
                 VALUES(?, ?, ?, ?);";

      $stmt = mysqli_prepare($conn, $query3);
      mysqli_stmt_bind_param($stmt, 'isii',
                             $product,
                             $variation_name,
                             $variation_price,
                             $variation_quantity);

      $product = $product_id;
      $variation_name = $variation['name'];
      $variation_price = $variation['price'];
      $variation_quantity = $variation['stock'];

      $result = mysqli_stmt_execute($stmt);
    }

    return $result;
  }
?>