<?php

  session_start();

  $type = $_REQUEST['type'];

  if(isset($_REQUEST['partnerId'])) {
    $applicationId = $_REQUEST['partnerId'];
  }

  switch($type) {
    case 'count-users': echo countUsers(); break;
    case 'count-pending-partners': echo countPendingPartners(); break;
    case 'count-pending-listings': echo countPendingListings(); break;
  }

  function countUsers() {
    include('../connect.php');
    include('../error.php');
    
    $getUsers = "SELECT COUNT(*) AS active_users
                 FROM users u
                 WHERE u.role = 'user'";

    $query = mysqli_query($conn, $getUsers);
    
    if (mysqli_num_rows($query) > 0) {
      $data = mysqli_fetch_assoc($query);
      return $data['active_users'];
    }

  }

  function countPendingPartners() {
    include('../connect.php');
    include('../error.php');

    $countPendingPartners = "SELECT COUNT(*) AS pending_partners
                             FROM partner_applications pa
                             WHERE pa.application_status = 'pending'";
    
    $query = mysqli_query($conn, $countPendingPartners);

    if (mysqli_num_rows($query) > 0) {
      $data = mysqli_fetch_assoc($query);
      return $data['pending_partners'];
    }
  }

  function countPendingListings() {
    include('../connect.php');
    include('../error.php');

    $countPendingListings = "SELECT COUNT(*) AS pending_listings
                             FROM listing_application la
                             WHERE la.listing_status = 'pending'";

    $query = mysqli_query($conn, $countPendingListings);

    if (mysqli_num_rows($query) > 0) {
      $data = mysqli_fetch_assoc($query);
      return $data['pending_listings'];
    }
  }

?>