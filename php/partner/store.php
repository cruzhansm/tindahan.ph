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

    function updateStoreDetails($details) {
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

    function jsonSerialize() {
      $data = get_object_vars($this);

      return $data;
    }

    static function createStore($details) {
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
  }
  
?>