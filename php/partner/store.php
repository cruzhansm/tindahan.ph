<?php

  class PartnerStore implements JsonSerializable {
    private $store_id;
    private $store_owner;
    private $store_name;
    private $store_img;
    private $store_description;
    private $store_active;
    private $store_suspended;
    private $store_contact;
    private $store_address;

    public function __construct($user_id) {
      $store = $this->fetchStoreDetails($user_id);

      $this->store_id = $store['store_id'];
      $this->store_owner = $store['user_id'];
      $this->store_name = $store['store_name'];
      $this->store_img = $store['store_img'];
      $this->store_description = $store['store_description'];
      $this->store_active = $store['active'];
      $this->store_suspended = $store['suspended'];
      $this->store_contact = $store['phone'];
      $this->store_address = $store['barangay'] . ', ' . $store['city'];
    }

    private function fetchStoreDetails($user_id) {
      include('../connect.php');

      $query = "SELECT p.*, u.phone, ua.barangay, ua.city
                FROM partner_store p
                JOIN users u ON u.user_id = p.user_id
                JOIN users_address ua ON p.user_id = ua.user_id
                WHERE p.user_id = $user_id;";

      $store = mysqli_fetch_assoc(mysqli_query($conn, $query));

      return $store;
    }

    public function updateStoreDetails($details) {
      include('../connect.php');

      $user = $this->store_owner;

      $query = "UPDATE partner_store
                SET store_name = ?, store_img = ?, store_description = ?
                WHERE user_id = $user;";

      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'sss',
                             $store_name,
                             $store_img,
                             $store_description);
        
      $store_name = $details['storeName'];
      $store_img = $details['storeImg'];
      $store_description = $details['storeDesc'];

      $result = mysqli_stmt_execute($stmt);

      mysqli_close($conn);

      return $result;
    }

    public function retrieveOrders() {
      include('../connect.php');

      $store_id = $this->store_id;

      $query = "SELECT CONCAT(u.fname, ' ', u.lname) AS `customer`, p.product_name, p.product_img, pr.variation, od.order_quantity, od.order_price, o.order_id, o.order_status
                FROM order_details od
                JOIN orders o ON o.order_id = od.order_id
                JOIN users u ON u.user_id = o.user_id
                JOIN cart_items ci ON ci.cart_item_id = od.cart_item_id
                JOIN product_variation pr ON pr.variation_id = ci.variation_id
                JOIN products p ON p.product_id = ci.product_id
                WHERE p.product_store = $store_id
                ORDER BY od.order_id DESC;";

      $result = mysqli_query($conn, $query);

      $orders = array();

      if(mysqli_num_rows($result) > 0 ) {
        while($order = mysqli_fetch_assoc($result)) {
          array_push($orders, $order);
        }
      }

      return $orders;
    }

    public static function createStore($details) {
      include('../connect.php');

      $user_id = $details['user_id'];
      $store_name = $details['store_name'];
      $store_img = $details['store_img'];
      $store_desc = $details['store_desc'];


      $insertStore = "INSERT INTO 
                      partner_store(user_id, store_name,
                                    store_img, store_description)
                      VALUES ($user_id, '$store_name', 
                              '$store_img', '$store_desc')";
                          
      $query = mysqli_query($conn, $insertStore);

      return $query ? true : new CustomError("Insert Error: ", "Not inserted"); 
    }

    public static function retrieveProducts($store_id) {
      include('../connect.php');

      $query = "SELECT *
                FROM products
                WHERE product_store = $store_id;";

      $result = mysqli_query($conn, $query);

      $products = array();

      if(mysqli_num_rows($result) > 0) {
        while($product = mysqli_fetch_assoc($result)) {
          array_push($products, $product);
        }
      }

      return $products;
    }

    function jsonSerialize() {
      $data = get_object_vars($this);

      return $data;
    }

  }
  
?>

