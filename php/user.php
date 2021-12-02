<?php

class User implements JsonSerializable {
  private $user_id;
  private $password;
  private $fname;
  private $lname;
  private $email;
  private $image;
  private $phone;
  private $role;
  private $active;
  private $suspended;

  function __construct($email, $password) {
    $this->email = $email;
    $this->password = $password;
  }
  
  function verifyEmail($remail) {
    return strcmp($this->email, $remail);
  }

  function verifyPassword() {
    include('connect.php');
    
    $query = "SELECT password
              FROM users
              WHERE email = '$this->email';";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);
    $rpass = $row['password'];
    return password_verify($this->password, $rpass);
  }

  function verifyActive() {
    return strcmp($this->active, 'true') == 0 ? true : false;
  }

  function verifyNotSuspended() {
    return strcmp($this->suspended, 'false') == 0 ? true : false;
  }

  function getFullName() {
    return $this->fname . ' ' . $this->lname;
  }

  function updateLastLogin() {
    include('connect.php');

    $gmt7 = 7*60*60;
    $currentTimestamp = date("Y-m-d H:i:s", time() + $gmt7);
    $query = "UPDATE users
              SET last_login = '$currentTimestamp'
              WHERE email = '$this->email';";

    mysqli_query($conn, $query);
  }

  function exists() {
    include('connect.php');

    $query = "SELECT *
              FROM users
              WHERE email = '$this->email';";
    $result = mysqli_query($conn, $query);

    mysqli_num_rows($result) > 0 ? true : false;
  }

  function fetchDetails() {
    include('connect.php');

    $query = "SELECT *
              FROM users
              WHERE email = '$this->email';";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
      $user = mysqli_fetch_assoc($result);
      $this->user_id = $user['user_id'];
      $this->fname = $user['fname'];
      $this->lname = $user['lname'];
      $this->image = $user['image'];
      $this->phone = $user['phone'];
      $this->role = $user['role'];
      $this->active = $user['active'];
      $this->suspended = $user['suspended'];

      return true;
    }
    else {
      return false;
    }
  }

  function getEmail() {
    return $this->email;
  }

  function getPassword() {
    return $this->password;
  }

  function jsonSerialize() {
    $data = get_object_vars($this);

    return $data;
  }
}
?>