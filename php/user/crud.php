<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'partner-application-check':
      echo json_encode(checkIfUserHasApplied()); break;
    case 'retrieve-user-address':
      echo json_encode(getUserAddress()); break;
  }

  function checkIfUserHasApplied() {
    include('../user.php');

    $exists = User::hasApplication();

    return $exists;
  }

  function getUserAddress() {
    include('../user.php');
    include('../common/user-address.php');

    $user_id = $_SESSION['user_id'];

    $user_address = new UserAddress($user_id);

    $user_details['user_fname'] = $_SESSION['fname'];
    $user_details['user_lname'] = $_SESSION['lname'];
    $user_details['user_address'] = $user_address;
    $user_details['user_contact'] = $_SESSION['phone'];

    return $user_details;
  }

?>