<?php

  class UserAddress implements JsonSerializable {
    private $user_id;
    private $user_street;
    private $user_city;
    private $user_barangay;
    private $user_landmark;
    private $user_zipcode;

    function __construct($user_id) {
      $user_address = $this->fetchUserAddress($user_id);

      if($user_address != false) {
        $this->user_id = intval($user_address['user_id']);
        $this->user_street = $user_address['street'];
        $this->user_city = $user_address['city'];
        $this->user_barangay = $user_address['barangay'];
        $this->user_landmark = $user_address['landmark'];
        $this->user_zipcode = intval($user_address['zipcode']);
      }
    }

    private function fetchUserAddress($user_id) {
      include('../connect.php');
      
      $query = "SELECT *
                FROM users_address
                WHERE user_id = $user_id;";

      $user_address = mysqli_fetch_assoc(mysqli_query($conn, $query));

      return $user_address;
    }

    public function updatePartnerStoreAddress($details) {
      include('../connect.php');

      $user_id = $this->user_id;

      $query = "UPDATE users_address
                SET city = ?, barangay = ?
                WHERE user_id = $user_id;";

      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'ss',
                             $store_city,
                             $store_barangay);

      $address = explode(', ', $details['storeAddress']);
      $store_barangay = $address[0];
      $store_city = $address[1];

      $result = mysqli_stmt_execute($stmt);

      return $result;
    }

    public function jsonSerialize() {
      $data = get_object_vars($this);

      return $data;
    }
  }

?>