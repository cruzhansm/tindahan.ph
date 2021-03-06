  <?php
  class Product implements JsonSerializable {
    private $product_id;
    private $product_store;
    private $store_owner;
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
      $this->store_owner = $product['user_id'];
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

      $query = "SELECT p.*, ps.user_id
                FROM products p
                JOIN partner_store ps ON p.product_store = ps.store_id
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
        while($row = mysqli_fetch_assoc($result)) {
          // GET THE REVIEW IMAGES, IF ANY and 
          // APPEND THE REVIEW TO THE RESULT SET
          $timestamp = $row['timestamp'];
          $rimages = "SELECT ui.img_path
                      FROM uploaded_img ui
                      JOIN image_collection ic ON ic.uploaded_img_id = ui.uploaded_img_id
                      WHERE ic.uploaded = '$timestamp';";

          $res = mysqli_query($conn, $rimages);

          $row['images'] = array();

          if(mysqli_num_rows($res) > 0) {
            while($image = mysqli_fetch_assoc($res)) {
              array_push($row['images'], $image['img_path']);
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

    public static function fetchByCategoryID($category_id) {
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

    //  Inserts a product in the db (complete)
    static function createProduct($applicationID) {
      include('../connect.php');

      $applicationID = intval($applicationID);

      $query1 = "SELECT * 
                 FROM listing_application
                 WHERE application_id = $applicationID;";

      $application = mysqli_fetch_assoc(mysqli_query($conn, $query1));

      $product_store = intval($application['listing_store']);
      $product_name = $application['listing_name'];
      $product_img = $application['listing_img'];
      $product_price = intval($application['listing_price']);
      $product_desc = $application['listing_desc'];
      $product_brand = $application['listing_brand'];
      $product_quantity = intval($application['listing_quantity']);

      $insertProduct = "INSERT INTO products (product_name, product_img, product_price, product_desc, product_quantity, product_brand, product_store)
                        VALUES('$product_name', '$product_img', $product_price, '$product_desc', $product_quantity, '$product_brand', $product_store);";

      $result = mysqli_query($conn, $insertProduct);

      return mysqli_insert_id($conn);
    }

    //  Updates status of listing app (complete)
    static function updateApplicationStatus($applicationId, $status) {
      include('../connect.php');

      $updateRole = "UPDATE listing_application
                     SET listing_status = '$status'
                     WHERE application_id = $applicationId";

      $query = mysqli_query($conn, $updateRole);

      return $query ? true : false;
    }

    public static function createCategory($applicationId, $productId) {
      
      include('../connect.php');
      
      $applicationId = intval($applicationId);

      $query = "SELECT category_id
                FROM listing_categories
                WHERE application_id = $applicationId";
      
      $result = mysqli_query($conn, $query);
      
      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          $categoryId = $row['category_id'];

          $query2 = "INSERT INTO product_category_list (product_id, category_id)
                     VALUES($productId, $categoryId)";

          mysqli_query($conn, $query2);
        }
      }
      
      return $result;
    }

    //  Inserts variations in db (productId problem)
    public static function createVariations($applicationId, $productId) {

      include('../connect.php');
      
      $query = "SELECT variation, price, quantity
                       FROM listing_variations
                       WHERE application_id = $applicationId";
      
      $result = mysqli_query($conn, $query);
      
      if(mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
              $variation = $row['variation'];
              $price = $row['price'];
              $quantity = $row['quantity'];
              
              $query2 = "INSERT INTO product_variation (product_id, variation, price, quantity)
                                  VALUES($productId, '$variation', $price, $quantity)";
              
              mysqli_query($conn, $query2);
          }
      }
      
      return $result;
  }

    public function addReview($review, $user_id) {
      include('../connect.php');

      $order_product_id = intval($review['orderProduct']);
      $imgs = $review['reviewImgs'];

      $query = "INSERT INTO product_review (product_id, user_id, rating, timestamp, review_msg)
                VALUES(?, ?, ?, ?, ?);";

      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'iiiss', 
                             $product_id,
                             $user,
                             $rating, 
                             $currentTimestamp,
                             $review_msg);

      $product_id = $this->product_id;
      $user = $user_id;
      $rating = intval($review['rating']);
      $gmt7 = 7*60*60;
      $currentTimestamp = date("Y-m-d H:i:s", time() + $gmt7);
      $review_msg = $review['review'];

      $result = mysqli_stmt_execute($stmt);

      $review_id = mysqli_insert_id($conn);

      if($result == true) {
        foreach($imgs as $img) {
          $query2 = "INSERT INTO uploaded_img (img_path) VALUES('$img');";
          mysqli_query($conn, $query2);
          
          $uploaded_img_id = mysqli_insert_id($conn);

          $query3 = "INSERT INTO image_collection (uploaded, uploaded_img_id)
                     VALUES('$currentTimestamp', $uploaded_img_id);";

          mysqli_query($conn, $query3);
        }

        $query4 = "UPDATE order_details
                   SET review_id = $review_id
                   WHERE order_product_id = $order_product_id;";
        
        mysqli_query($conn, $query4);
      }

      return $result; 
    }

    public function updateProductRating($product_id) {
      include('../connect.php');

      $query ="UPDATE products
               SET product_rating = (SELECT AVG(rating)
                                     FROM product_review
                                     WHERE product_id = $product_id)
               WHERE product_id = $product_id;";

      $result = mysqli_query($conn, $query);
      
      return $result;
    }

    function jsonSerialize() {
      $data = get_object_vars($this);
  
      return $data;
    }

    static function fetchBySearchQuery($user_query) {
      include('../connect.php');
      
      $products = array();
      $query = "SELECT product_id
                FROM products
                WHERE product_name LIKE ?";
      $stmt = mysqli_prepare($conn, $query);

      mysqli_stmt_bind_param($stmt, 's', $product_search);
      $product_search = "%$user_query%";

      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      $i = 0;
      while($data = mysqli_fetch_assoc($result)) {
        $products[$i] = (int)$data['product_id'];
        $i++;
      }
      
      return $products;
    }

    static function changeSuspensionStatus($prodId, $status) {
      include('../connect.php');

      $changeStatus = "UPDATE products
                       SET suspended = '$status'
                       WHERE product_id = $prodId";

      $query = mysqli_query($conn, $changeStatus);

      return $query ? true : false;
    }

    static function changeActive($prodId, $status) {
      include('../connect.php');

      $changeActive = "UPDATE products
                       SET active = '$status'
                       WHERE product_id = $prodId";

      $query = mysqli_query($conn, $changeActive);

      return $query ? true : false;
    }
  }
?>