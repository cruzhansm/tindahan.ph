<?php

  session_start();

  $transaction = $_REQUEST['type'];
  
  if(isset($_REQUEST['num'])) {
    $num = $_REQUEST['num'];
  }

  switch($transaction) {
    case 'multiple-random': 
      echo json_encode(fetchMultipleRandomProducts($num));
      break;
  }

  function fetchMultipleRandomProducts($num) {
    include_once('../connect.php');
    include_once('./product.php');

    $retrieve = "SELECT * FROM products ORDER BY RAND() LIMIT $num;";
    $products = mysqli_fetch_all(mysqli_query($conn, $retrieve), MYSQLI_ASSOC);
    
    $resultSet = [];

    foreach($products as $product) {
      $data = new Product($product['product_id'], $product['product_name'], $product['product_img'], $product['product_price'], $product['product_desc']);

      array_push($resultSet, $data);
    }
    return $resultSet;
  }
?>