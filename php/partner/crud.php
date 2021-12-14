<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'retrieve-store-details':
      echo json_encode(fetchStoreDetails()); break;
    case 'retrieve-store-w-id':
      echo json_encode(fetchStoreDetailsUsingID()); break;
    case 'update-store-profile':
      echo json_encode(updateStoreDetails()); break;
    case 'retrieve-store-products':
      echo json_encode(retrieveStoreProducts()); break;
  }

  function fetchStoreDetails() {
    include('store.php');

    $user_id = $_SESSION['user_id'];
    
    $store = new PartnerStore($user_id);
     
    return $store->jsonSerialize();
  }

  function fetchStoreDetailsUsingID() {
    include('../connect.php');
    include('store.php');


    $store_id = $_REQUEST['storeID'];

    $query = "SELECT user_id FROM partner_store WHERE store_id = $store_id;";

    $result = mysqli_fetch_assoc(mysqli_query($conn, $query));

    $store = new PartnerStore($result['user_id']);

    return $store->jsonSerialize();
  }

  function updateStoreDetails() {
    include('store.php');
    include('../error.php');
    include('../user.php');
    include('../common/user-address.php');

    $editDetails = json_decode($_REQUEST['editDetails'], MYSQLI_ASSOC);
    
    $store = new PartnerStore($_SESSION['user_id']);
    $result = $store->updateStoreDetails($editDetails);

    $user_address = new UserAddress($_SESSION['user_id']);
    $result = $user_address->updatePartnerStoreAddress($editDetails);

    $result = User::updateContact($_SESSION['user_id'], $editDetails['storeContact']);
    
    return $result;
  }

  function retrieveStoreProducts() {
    include('store.php');

    $store_id = $_REQUEST['storeID'];

    return PartnerStore::retrieveProducts($store_id);
  }

?>