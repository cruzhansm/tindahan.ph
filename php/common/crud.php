<?php

  session_start();

  $request = $_REQUEST['type'];

  if(isset($_REQUEST['id'])) {
    $category_id = $_REQUEST['id'];
  }

  if(isset($_REQUEST['category'])) {
    $category = $_REQUEST['category'];
  }

  switch($request) {
    case('retrieve'): echo json_encode(retrieveCategories()); break;
    case('title'): echo retrieveTitle($category_id); break;
    case('products-results'): echo json_encode(retrieveProducts($category)); break;
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

  function retrieveTitle($category_id) {
    include_once('../connect.php');

    $query = "SELECT category_name
              FROM product_category
              WHERE category_id = '$category_id'";
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0) {
      $data = mysqli_fetch_assoc($result);
      return $data['category_name'];
    }
  }

  function retrieveProducts($category) {
    include_once('../connect.php');
    include_once('../products/product.php');

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