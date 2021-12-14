<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'partner-application-check':
      echo json_encode(checkIfUserHasApplied()); break;
    case 'retrieve-user-address':
      echo json_encode(getUserAddress()); break;
    case 'create-user-tabs':
      echo json_encode(createUserTabs()); break;
    case 'suspend-user':
      echo json_encode(suspendUser()); break;
    case 'delete-user':
      echo json_encode(deleteUser()); break;
    case 'retrieve-user-id':
      echo json_encode($_SESSION['user_id']); break;
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

  function createUserTabs() {
    include('../connect.php');

    $users = array();

    $userInfo = "SELECT *
                 FROM users u
                 WHERE u.active = 'true'
                       AND u.role != 'admin'";

    $query = mysqli_query($conn, $userInfo);

    if (mysqli_num_rows($query) > 0) {
      while ($data = mysqli_fetch_assoc($query)) {
        $users[] = $data;
      }
    }
    return $users;
  }

  function suspendUser() {
    include('../connect.php');
    include('../user.php');

    $users = array();
    $users = $_REQUEST['user'];

    $result = User::changeSuspension($users['user_id'], 'true');
    $result = User::createUserSuspension($users['user_id']);

    return $result == true ? true : false;
  }

  function deleteUser() {
    include('../connect.php');
    include('../user.php');

    $users = array();
    $users = $_REQUEST['user'];

    $result = User::changeActive($users['user_id'], 'false');

    return $result == true ? true : false;
  }

?>