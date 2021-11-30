<?php

  session_start();

  include_once('./user.php');
  include_once('./error.php');

  $request = $_REQUEST['type'];
  if(isset($_REQUEST['email'])) {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
  }

  switch($request) {
    case('probe'): echo json_encode(checkIfExist()); break;
    case('login'): echo json_encode(login()); break;
    case('signup'): echo json_encode(register()); break;
    case('logout'): logout(); break;
  }

  function checkIfExist() {
    $user = new User($GLOBALS['email'], $GLOBALS['password']);

    return $user->fetchDetails();
  }

  function login() {
    
    if(checkIfExist()) {
      $password = $GLOBALS['password'];
      $user = new User($GLOBALS['email'], $password);
      if($user->verifyPassword()) {
        $user->fetchDetails();
        $user->updateLastLogin();
      }
      else { return new CustomError('password', 'You entered the wrong password.'); }
    }
    else { return ; }

    if($user->verifyActive() == false) {
      $error = new CustomError('inactive', 'Account does not exist.');

      return $error;
    }

    if($user->verifyNotSuspended() == false) {
      $error = new CustomError('suspended', 'Your account is currently suspended.');

      return $error;
    }

    if($user->verifyEmail($user->getEmail()) != 0) {
      $error = new CustomError('email', 'That email is not associated with any account.');

      return $error;
    }

    $data = $user->jsonSerialize();
    $_SESSION['user_id'] = $data['user_id'];
    $_SESSION['fname'] = $data['fname'];
    $_SESSION['lname'] = $data['lname'];
    $_SESSION['cname'] = $user->getFullName();
    $_SESSION['image'] = $data['image'];
    $_SESSION['phone'] = $data['phone'];
    $_SESSION['role'] = $data['role'];

    return $user == false ? new CustomError('user', 'User does not exist.') : $data['role'];
  }

  function register() {
    include_once('./connect.php');

    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];

    $password = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO users (fname, lname, password, email)
              VALUES ('$fname', '$lname', '$password', '$email');";
    
    return (mysqli_query($conn, $query) == false) ? new CustomError('signup', 'Could not complete operation.') : '';
  }
  
  function logout() {
    $_SESSION = array();

    session_destroy();
  }
?>