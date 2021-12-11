<?php

  class Order {
    private $order_id;
    private $order_date_placed;
    private $order_recipient;
    private $order_recipient_contact;
    private $order_recipient_address;
    private $order_date_shipped;
    private $order_date_fulfilled;
    private $order_price;
    private $order_status;
    private $order_status_msg;

    public function __construct($order_id) {

    }

    public static function newOrder($order) {
      include('../connect.php');

      $products = $order['products'];
      $price = $order['totalPrice'];

      if(count($products) > 0) {
        $query = "INSERT INTO orders (order_total_price) VALUES ($price);";
  
        $result = mysqli_query($conn, $query);
  
        $last_id = mysqli_insert_id($conn);
  
        foreach($products as $product) {
          $order_cart_id = $product['cartItemID'];
          $order_quantity = $product['orderQuantity'];
          $order_price = $product['orderPrice'];
  
          $query2 = "INSERT INTO order_details (cart_item_id, order_id, order_quantity, order_price)
                   VALUES ($order_cart_id, $last_id, $order_quantity, $order_price);";
          
          $result = mysqli_query($conn, $query2);
        }
      }
      else { 
        $result = false;
      }

      return $result;
    }
  }

?>