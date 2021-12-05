<?php

  class PartnerStore implements JsonSerializable {
    private $store_id;
    private $store_owner;
    private $store_name;
    private $store_followers;
    private $store_img;
    private $store_rating;
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
      $this->store_followers = $store['store_followers'];
      $this->store_img = $store['store_img'];
      $this->store_rating = $store['store_rating'];
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

    function jsonSerialize() {
      $data = get_object_vars($this);

      return $data;
    }
  } 

?>