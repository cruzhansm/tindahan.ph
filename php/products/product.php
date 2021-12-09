<?php
  class Product implements JsonSerializable {
    private $product_id;
    private $product_store;
    private $product_name;
    private $product_img;
    private $product_price;
    private $product_desc;
    private $product_brand;
    private $product_quantity;
    private $product_rating;
    private $product_categories;
    private $product_variations;
    private $product_reviews;
    private $review_count;

    function __construct($product_id) {
      $this->product_id = $product_id;
      
      $product = $this->fetchProductDetails($product_id);

      $this->product_name = $product['product_name'];
      $this->product_img = $product['product_img'];
      $this->product_price = $product['product_price'];
      $this->product_desc = $product['product_desc'];
      $this->product_rating = $product['product_rating'];
      $this->product_brand = $product['product_brand'];
      $this->product_quantity = $product['product_quantity'];
      $this->product_store = $this->fetchProductStore();
      $this->product_categories = $this->fetchProductCategories();
      $this->product_variations = $this->fetchProductVariations();
      $this->product_reviews = $this->fetchProductReviews();
      $this->review_count = $this->fetchProductReviewCount();
    }

    private function fetchProductStore() {
      include('../connect.php');

      $product_id = $this->product_id;

      $query = "SELECT ps.store_id, ps.store_name
                FROM partner_store ps
                JOIN products p ON p.product_store = ps.store_id
                WHERE p.product_id = $product_id;";

      $result = mysqli_fetch_assoc(mysqli_query($conn, $query));   
     
      return $result;
    }

    private function fetchProductDetails() {
      include('../connect.php');

      $product_id = $this->product_id;

      $query = "SELECT *
                FROM products
                WHERE product_id = $product_id;";

      $product = mysqli_fetch_assoc(mysqli_query($conn, $query));

      return $product;
    }

    private function fetchProductCategories() {
      include('../connect.php');

      $product_id = $this->product_id;

      $query = "SELECT c.category_name
                FROM product_category c
                JOIN product_category_list pcl ON pcl.category_id = c.category_id
                WHERE pcl.product_id = $product_id";
      
      $result = mysqli_query($conn, $query);

      $categories = array();

      if(mysqli_num_rows($result) > 0) {
        $i = 0;
        while($row = mysqli_fetch_assoc($result)) {
          $categories[$i] = $row['category_name'];
          $i++;
        }
      }

      return $categories;
    }

    private function fetchProductReviews() {
      include('../connect.php');
      
      $product_id = $this->product_id;

      // GET THE REVIEW ITSELF AND THE REVIEWER
      $query = "SELECT pr.review_id, pr.user_id, pr.rating, timestamp, pr.review_msg, CONCAT(u.fname, ' ', u.lname) AS 'user_name'
                FROM product_review pr
                JOIN users u ON u.user_id = pr.user_id
                WHERE product_id = $product_id;";

      $result = mysqli_query($conn, $query);  
      
      $reviews = array();

      if(mysqli_num_rows($result) > 0) {
        $i = 0;
        $j = 0;
        while($row = mysqli_fetch_assoc($result)) {
          // GET THE REVIEW IMAGES, IF ANY and 
          // APPEND THE REVIEW TO THE RESULT SET
          $timestamp = $row['timestamp'];
          $rimages = "SELECT ui.img_path
                      FROM uploaded_img ui
                      JOIN image_collection ic ON ic.uploaded_img_id = ui.uploaded_img_id
                      WHERE ic.uploaded = '$timestamp';";

          $res = mysqli_query($conn, $rimages);
          
          if(mysqli_num_rows($res) > 0) {
            while($image = mysqli_fetch_assoc($res)) {
              $row['images'][$j] = $image['img_path'];
              $j++;
            }
          }
          else {
            $row['images'] = [];
          }

          $reviews[$i] = $row;
          $i++;
        }
      }

      
      return $reviews;
    }

    private function fetchProductVariations() {
      include('../connect.php');
      
      $product_id = $this->product_id;

      $query = "SELECT variation_id, variation, price, quantity
                FROM product_variation
                WHERE product_id = $product_id;";

      $result = mysqli_query($conn, $query);

      $variations = array();
      
      if(mysqli_num_rows($result) > 0) {
        $i= 0;
        while($row = mysqli_fetch_assoc($result)) {
          $variations[$i] = $row;
          $i++;
        }
      }

      return $variations;
    }

    private function fetchProductReviewCount() {
      include('../connect.php');

      $product_id = $this->product_id;

      $query = "SELECT COUNT(*) as 'review_count' 
                FROM product_review
                WHERE product_id = $product_id
                GROUP BY product_id;";
      
      $result = mysqli_fetch_assoc(mysqli_query($conn, $query));

      return $result == false ? 0 : $result['review_count'];
    } 
    
    public static function checkIfExists($product_id) {
      include('../connect.php');

      $query = "SELECT *
                FROM products
                WHERE product_id = $product_id;";
      
      $result = mysqli_query($conn, $query);

      return mysqli_num_rows($result) > 0 ? true : false;
    }

    function jsonSerialize() {
      $data = get_object_vars($this);
  
      return $data;
    }

    static function fetchByCategoryID($category_id) {
      include('../connect.php');
      $products = array();
      $query = "SELECT product_id
                FROM product_category_list
                WHERE category_id = '$category_id'";
      $result = mysqli_query($conn, $query);

      if(mysqli_num_rows($result) > 0 ){
        $i = 0;
        while($data = mysqli_fetch_assoc($result)){
          $products[$i] = (int)$data['product_id'];
          $i++;
        }
      }
      return $products;
    }

  }

?>