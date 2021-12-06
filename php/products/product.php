<?php

  class Product {
    public $product_id;
    public $product_name;
    public $product_img;
    public $product_price;
    public $product_desc;
    public $product_categories;
    public $product_variations;
    public $product_reviews;

    function __construct($product_id, $product_name, $product_img, $product_price, $product_desc) {
      $this->product_id = $product_id;
      $this->product_name = $product_name;
      $this->product_img = $product_img;
      $this->product_price = $product_price;
      $this->product_desc = $product_desc;
      $this->product_categories = $this->fetchProductCategories();
      $this->product_variations = $this->fetchProductVariations();
      $this->product_reviews = $this->fetchProductReviews();
    }

    function fetchProductCategories() {
      include_once('../connect.php');
      $query = "SELECT *
                FROM product_category_list
                WHERE category_id = '$this->product_id'";

      // $result = mysqli_fetch_all(mysqli_query($conn, $query), MYSQLI_ASSOC);

      return [];
    }

    function fetchProductReviews() {
      include_once('../connect.php');
      $query = "SELECT *
                FROM review_list
                WHERE category_id = '$this->product_id'";

      // $result = mysqli_fetch_all(mysqli_query($conn, $query), MYSQLI_ASSOC);

      return [];
    }

    function fetchProductVariations() {
      include_once('../connect.php');
      $query = "SELECT *
                FROM product_variation_list
                WHERE category_id = '$this->product_id'";

      // $result = mysqli_fetch_all(mysqli_query($conn, $query), MYSQLI_ASSOC);

      return [];
    }
    
    function jsonSerialize() {
      $data = get_object_vars($this);
  
      return $data;
    }

  }

?>