<?php

  session_start();

  $type = $_REQUEST['type'];

  if(isset($_REQUEST['partnerId'])) {
    $applicationId = $_REQUEST['partnerId'];
  }

  switch($type) {
    case 'count-users': echo json_encode(countUsers()); break;
    case 'count-pending-partners': echo json_encode(countPendingPartners()); break;
    case 'count-pending-listings': echo json_encode(countPendingListings()); break;
    case 'get-three-latest-various': echo json_encode(getLatestFromVarious()); break;
  }

  function countUsers() {
    include('../connect.php');
    
    $getUsers = "SELECT COUNT(*) AS active_users
                 FROM users u
                 WHERE u.role = 'user'";

    $data = mysqli_fetch_assoc(mysqli_query($conn, $getUsers));

    return $data['active_users'];
  }

  function countPendingPartners() {
    include('../connect.php');
    include('../error.php');

    $countPendingPartners = "SELECT COUNT(*) AS pending_partners
                             FROM partner_applications pa
                             WHERE pa.application_status = 'pending'";
    
    $data =  mysqli_fetch_assoc(mysqli_query($conn, $countPendingPartners));

    return $data['pending_partners'];
  }

  function countPendingListings() {
    include('../connect.php');
    include('../error.php');

    $countPendingListings = "SELECT COUNT(*) AS pending_listings
                             FROM listing_application la
                             WHERE la.listing_status = 'pending'";

    $data = mysqli_fetch_assoc(mysqli_query($conn, $countPendingListings));

    return $data['pending_listings'];
  }
 
  function getLatestFromVarious() {
    include('../connect.php');
    include('../user.php');
    include('../partner-applications/partner-application.php');

    $query = "SELECT la.application_id, la.listing_name, ps.store_name
              FROM listing_application la
              JOIN partner_store ps ON ps.store_id = la.listing_store
              WHERE la.listing_status = 'pending'
              ORDER BY la.application_id DESC
              LIMIT 3";

    $result = mysqli_query($conn, $query);

    $latest = array();

    $latest['users'] = User::getUsers(3);
    $latest['applications'] = PartnerApplication::getApplications(3);

    $listings = array();

    if(mysqli_num_rows($result) > 0) {
      while($listing = mysqli_fetch_assoc($result)) {
        array_push($listings, $listing);
      }
    }

    $latest['listings'] = $listings;

    return $latest;
  }
?>