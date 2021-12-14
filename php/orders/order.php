<?php

  class Order implements JsonSerializable {
    private $order_id;
    private $order_owner;
    private $order_date_placed;
    private $order_recipient;
    private $order_recipient_contact;
    private $order_recipient_address;
    private $order_date_shipped;
    private $order_date_fulfilled;
    private $order_price;
    private $order_status;
    private $order_status_msg;
    private $order_products;

    public function __construct($order_id) {
      $order = $this->fetchOrderDetails($order_id);
      $products = $this->fetchOrderProducts($order_id);

      $this->order_id = $order['order_id'];
      $this->order_owner = $order['user_id'];
      $this->order_date_placed = $order['order_date_placed'];
      $this->order_recipient = $order['order_recipient'];
      $this->order_recipient_contact = $order['order_recipient_contact'];
      $this->order_recipient_address = $order['order_recipient_address'];
      $this->order_date_shipped = $order['order_date_shipped'];
      $this->order_date_fulfilled = $order['order_date_fulfilled'];
      $this->order_price = $order['order_total_price'];
      $this->order_status = $order['order_status'];
      $this->order_status_msg = $order['order_status_msg'];
      $this->order_products = $products;
    }

    private function fetchOrderDetails($order_id) {
      include('../connect.php');
      $query = "SELECT o.*, os.order_status_msg
                FROM orders o
                JOIN order_status os ON os.order_status = o.order_status
                WHERE order_id = $order_id;";

      $result = mysqli_fetch_assoc(mysqli_query($conn, $query));

      return $result;
    }

    private function fetchOrderProducts($order_id) {
      include('../connect.php');
      $query ="SELECT od.*, p.product_id, ps.store_name, p.product_img, p.product_name, pv.variation
               FROM order_details od
               JOIN cart_items ci ON ci.cart_item_id = od.cart_item_id
               JOIN products p ON p.product_id = ci.product_id
               JOIN partner_store ps ON ps.store_id = p.product_store
               JOIN product_variation pv ON pv.variation_id = ci.variation_id 
               WHERE od.order_id = $order_id;";

      $result = mysqli_query($conn, $query);
      
      $products = array();

      if(mysqli_num_rows($result) > 0) {
        while($product = mysqli_fetch_assoc($result)) {
          foreach($product as $x => $val) {
            if(intval($val) != 0) {
              $product[$x] = intval($val);
            }
          }
          array_push($products, $product);
        }
      }

      return $result == true ? $products : false;
    }

    public static function newOrder($user_id, $order, $recipient) {
      include('../connect.php');

      $products = $order['products'];
      $price = $order['totalPrice'];

      $order_recipient = $recipient['recipientName'];
      $order_recipient_contact = $recipient['recipientContact'];
      $order_recipient_address = $recipient['recipientAddress'];

      if(count($products) > 0) {
        $query = "INSERT INTO orders (user_id, order_recipient, order_recipient_contact, order_recipient_address, order_total_price) 
                  VALUES ($user_id, '$order_recipient', $order_recipient_contact, '$order_recipient_address', $price);";
  
        $result = mysqli_query($conn, $query);
  
        $last_id = mysqli_insert_id($conn);
  
        foreach($products as $product) {
          $order_cart_id = $product['cartItemID'];
          $order_quantity = $product['orderQuantity'];
          $order_price = $product['orderPrice'];
  
          $query2 = "INSERT INTO order_details (cart_item_id, order_id, order_quantity, order_price)
                   VALUES ($order_cart_id, $last_id, $order_quantity, $order_price);";
          
          $query3 = "UPDATE products
                     SET product_quantity = product_quantity - $order_quantity
                     WHERE product_id = (SELECT product_id
                                         FROM cart_items
                                         WHERE cart_item_id = $order_cart_id)";

          $result = mysqli_query($conn, $query2);
        }
      }
      else { 
        $result = false;
      }

      return $result;
    }

    public static function getLatestOrder($user_id) {
      include('../connect.php');
      
      $query = "SELECT order_id
                FROM orders
                WHERE user_id = $user_id
                      AND order_status = 'confirmation'
                ORDER BY order_id DESC
                LIMIT 1;";

      $result = mysqli_fetch_assoc(mysqli_query($conn, $query));

      return $result != null ? $result['order_id'] : false;
    }

    public static function fetchFakeOrderDetails($cart_item_id) {
      include('../connect.php');

      $query = "SELECT ci.product_id, ps.store_name, p.product_img, p.product_name, pv.variation
                FROM cart_items ci
                JOIN products p ON p.product_id = ci.product_id
                JOIN partner_store ps ON ps.store_id = p.product_store
                JOIN product_variation pv ON pv.variation_id = ci.variation_id
                WHERE ci.cart_item_id = $cart_item_id;";

      $result = mysqli_fetch_assoc(mysqli_query($conn, $query));

      return $result;
    }

    public function confirm() {
      include('../connect.php');

      $order_id = $this->order_id;

      $query = "UPDATE orders
                SET order_status = 'processing'
                WHERE order_id = $order_id;";
      
      $result = mysqli_query($conn, $query);

      return $result;
    }

    public function ship() {
      include('../connect.php');

      $order_id = $this->order_id;

      $query = "UPDATE orders
                SET order_status = 'shipped'
                WHERE order_id = $order_id;";
      
      $result = mysqli_query($conn, $query);

      return $result;
    }
    
    public function receive() {
      include('../connect.php');

      $order_id = $this->order_id;

      $query = "UPDATE orders
                SET order_status = 'delivered'
                WHERE order_id = $order_id;";
      
      $result = mysqli_query($conn, $query);

      return $result;
    }

    public function cancel() {
      include('../connect.php');

      $order_id = $this->order_id;

      $query = "UPDATE orders
                SET order_status = 'cancelled'
                WHERE order_id = $order_id;";
      
      $result = mysqli_query($conn, $query);

      return $result;
    }

    public function jsonSerialize() {
      $data = get_object_vars($this);
  
      return $data;
    }

  }

?>