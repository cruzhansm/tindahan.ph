<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'retrieve-store-details':
      echo json_encode(fetchStoreDetails()); break;
    case 'update-store-profile':
      echo json_encode(updateStoreDetails()); break;
  }

  function fetchStoreDetails() {
    include('store.php');

    $user_id = $_SESSION['user_id'];
    
    $store = new PartnerStore($user_id);
     
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
    
    return $result ? true : new CustomError(error: 'Input', error_msg: 'One or more fields has an invalid input.');
  }

?>