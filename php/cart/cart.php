<?php

  class Cart implements JsonSerializable {
    private $cart_owner;
    private $cart_items;

    public function __construct($user_id) {
      $this->cart_owner = $user_id;

      $this->cart_items = $this->fetchAllItems();
    }

    public function fetchAllItems() {
      include('../connect.php');

      $query = "SELECT ci.*, pv.variation, ps.store_id, ps.store_name
                FROM cart_items ci
                JOIN product_variation pv ON pv.variation_id = ci.variation_id
                JOIN products p ON p.product_id = ci.product_id
                JOIN partner_store ps ON ps.store_id = p.product_store
                WHERE ci.user_id = $this->cart_owner
                      AND ci.status = 'cart';";

      $result = mysqli_query($conn, $query);

      $items = array();

      if(mysqli_num_rows($result) > 0) {
        $i = 0;
        while($row = mysqli_fetch_assoc($result)) {
          $items[$i] = $row;
          $i++;
        }
      }

      return $items;
    }

    public function add($product) {
      include('../connect.php');

      $product_id = $product['productID'];
      $product_variation = $product['variationID'];
      $product_quantity = $product['quantity'];

      $query = "INSERT INTO cart_items (user_id, product_id, variation_id, quantity)
                VALUES ($this->cart_owner, $product_id, $product_variation, $product_quantity);";
      
      $result = mysqli_query($conn, $query);

      return $result;
    }

    function jsonSerialize() {
      $data = get_object_vars($this);
  
      return $data;
    }

  }

  

?>