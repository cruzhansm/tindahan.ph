<?php

  session_start();

  $request = $_REQUEST['type'];

  switch($request) {
    case('retrieve'): echo json_encode(retrieveCategories()); break;
    case('title'): echo retrieveTitle(); break;
    case('products-results'): echo json_encode(retrieveProducts()); break;
  }

  function retrieveCategories() {
    include_once('../connect.php');

    $categories = array();
    $query = 'SELECT * FROM product_category';
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){
      while($data = mysqli_fetch_assoc($result)){
        $categories[] = $data;
      }
    }
    return $categories;
  }

  function retrieveTitle() {
    include_once('../connect.php');
    $category_id = $_REQUEST['id'];

    $query = "SELECT category_name
              FROM product_category
              WHERE category_id = '$category_id'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0) {
      $data = mysqli_fetch_assoc($result);
      return $data['category_name'];
    }
  }

  function retrieveProducts() {
    include_once('../connect.php');
    include_once('../products/product.php');
    $category = $_REQUEST['category'];

    $products = array();
    $result = array();
    $products = Product::fetchByCategoryID($category);

    foreach($products as $x) {
      $data = new Product($x);
      array_push($result, $data);
    }
    return $result;
  }

?>