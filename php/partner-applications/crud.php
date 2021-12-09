<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'partner-application': insertPartnerApplication(); break;
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
?>