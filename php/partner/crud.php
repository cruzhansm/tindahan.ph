<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'retrieve-store-details':
      echo json_encode(fetchStoreDetails()); break;
  }

  function fetchStoreDetails() {
    include('store.php');

    $user_id = $_SESSION['user_id'];
    
    $store = new PartnerStore($user_id);
     
    return $store->jsonSerialize();
  }

?>