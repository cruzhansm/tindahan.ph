<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) {
    case 'partner-application-check':
      echo json_encode(checkIfUserHasApplied()); break;
  }

  function checkIfUserHasApplied() {
    include('../user.php');

    $exists = User::hasApplication();

    return $exists;
  }

?>