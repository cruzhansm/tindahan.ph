<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'partner-application': insertPartnerApplication(); break;
    case 'create-pending-partners-list': echo json_encode(createPendingPartners()); break;
    case 'approve-pending-partner': echo json_encode(approvedApplication()); break;
    case 'reject-pending-partner': echo json_encode(rejectedApplication()); break;
  }

  function insertPartnerApplication() {
    include('../connect.php');
    include('../error.php');
    include('./partner-application.php');

    $data = json_decode($_REQUEST['application'], true);
    $img = '/tindahan.ph/assets/mock/partner/' . $_FILES['file']['name'];

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

  //  Creates pending partners tabs (complete)
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
        array_push($rows, $data);
      }
    }
    return $rows;
  }

  //  Approval of Partner Application (complete)
  function approvedApplication() {
    include('../connect.php');
    include('../user.php');
    include('partner-application.php');
    include('../partner/store.php');

    $details = $_REQUEST['details'];
    $result = User::changeRole($details['user_id'], 'partner');
    $result = PartnerApplication::changeStatus($details['application_id'], 'approved');
    $result = PartnerStore::createStore($details);

    return $result == true ? true : new CustomError("Insert Error: ", "Not inserted");
  }

  //  Rejection of Partner Application (complete)
  function rejectedApplication() {
    include('../connect.php');
    include('../user.php');
    include('partner-application.php');

    $details = array();
    $details = $_REQUEST['details'];
    $result = PartnerApplication::changeStatus($details['application_id'], 'rejected');

    return $result == true ? true : new CustomError("Update Error: ", "Role not changed");
  }

?>