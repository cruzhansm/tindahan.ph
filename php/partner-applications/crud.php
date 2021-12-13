<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'partner-application': insertPartnerApplication(); break;
    case 'create-pending-partners-list': echo json_encode(createPendingPartners()); break;
    case 'show-pending-partners-details': echo json_encode(showPendingPartnersDetails($applicationId)); break;
  }

  function insertPartnerApplication() {
    include('../connect.php');
    include('../error.php');
    include('./partner-application.php');

    $data = json_decode($_REQUEST['application'], true);
    $img = '/tindahan.ph/assets/images/' . $_FILES['file']['name'];

    $exists = PartnerApplication::userHasApplied($_SESSION['user_id']);

    if(!$exists) {
      $application = new PartnerApplication($_SESSION['user_id'], 
                                          $data['storeName'],
                                          $data['storeCategory'],
                                          $data['storeDesc'],
                                          $img,
                                          $data['storeExperience'],
                                          $data['storePlatforms']);

      $result = $application->insertApplication();
      echo json_encode($result);
    }
    else {
      echo json_encode(new CustomError('exists', 'You have already applied for a partnership.'));
    }
  }

  function createPendingPartners() {
    include('../connect.php');
    include('../error.php');

    $rows = array();

    $pendingPartnersInfo = "SELECT *
                            FROM partner_applications pa
                            WHERE pa.application_status = 'pending'";

    $query = mysqli_query($conn, $pendingPartnersInfo);

    if (mysqli_num_rows($query) > 0) {
      while ($data = mysqli_fetch_assoc($query)) {
        $rows[] = $data;
      }
    }
    return $rows;
  }

  function showPendingPartnersDetails($applicationId) {
    include('../connect.php');

    $ppModalInfo = "SELECT *
                    FROM partner_applications pa
                    WHERE pa.application_id = '$applicationId'";

    $query = mysqli_query($conn, $ppModalInfo);

    if (mysqli_num_rows($query) > 0) {
      $data = mysqli_fetch_assoc($query);
    }
    return $data;
  }

  function approvedApplication($details) {
    include('../connect.php');
    include('../user.php');
    include('partner-application.php');

    User::changeRole($details['user_id'], 'partner');
    PartnerApplication::changeStatus($details['application_id'], 'approved');
    PartnerStore::createStore($details);
    

    return $query ? true : new CustomError("Insert Error: ", "Not inserted");
  }

  function rejectedApplication($details) {
    include('../connect.php');
    include('../user.php');

    PartnerApplication::changeStatus($details['application_id'], 'rejected');

    $query = mysqli_query($conn, $reject);

    return $query ? true : new CustomError("Update Error: ", "Role not changed");
  }
?>