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

    function updateLastLogin() {
      include('connect.php');

      $gmt7 = 7*60*60;
      $currentTimestamp = date("Y-m-d H:i:s", time() + $gmt7);
      $query = "UPDATE users
                SET last_login = '$currentTimestamp'
                WHERE email = '$this->email';";

      mysqli_query($conn, $query);
    }

    static function updateContact($user_id, $updated) {
      include('connect.php');

      $query = "UPDATE users
                SET phone = ?
                WHERE user_id = $user_id;";

      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'i', $contact);

      $contact = $updated;

      $result = mysqli_stmt_execute($stmt);

      return $result;
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

    function getFullName() {
      return $this->fname . ' ' . $this->lname;
    }

    function getEmail() {
      return $this->email;
    }

    function getPassword() {
      return $this->password;
    }

    static function hasApplication() {
      include('partner-applications/partner-application.php');

      return PartnerApplication::userHasApplied($_SESSION['user_id']);
    }

    function jsonSerialize() {
      $data = get_object_vars($this);

      return $data;
    } 

    static function getUserInfo($user_id) {
      include('connect.php');
      $query = "SELECT u.email, u.fname, u.lname, u.phone, u.image,
                       a.street, a.city, a.barangay, a.landmark, a.zipcode
                FROM users u LEFT JOIN users_address a
                ON u.user_id = a.user_id
                WHERE u.user_id = '$user_id'";
      $result = mysqli_query($conn, $query);

      if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
      }else{
        $data = "error";
      }

      return $data;
    }

    static function updateUserInfo($updateInfo, $user_id) {
      include('connect.php');

      $query = "UPDATE users
                SET fname = ?, lname = ?, image = ?, phone = ?
                WHERE user_id = $user_id";
      
      $stmt = mysqli_prepare($conn, $query);

      mysqli_stmt_bind_param($stmt, 'sssi',
                             $user_fname,
                             $user_lname,
                             $user_img,
                             $user_phone);
      
      $user_fname = $updateInfo['userfName'];
      $user_lname = $updateInfo['userlName'];
      $user_img = $updateInfo['userImg'] == "" ? "/tindahan.ph/assets/mock/users/placeholder.png" : $updateInfo['userImg'];
      $user_phone = $updateInfo['userPhone'] == "" || $updateInfo['userPhone'] == 0 ? NULL : $updateInfo['userPhone'];
      
      $result = mysqli_stmt_execute($stmt);

      mysqli_close($conn);

      return $result;
    }

    static function updateEmail($user_id, $email) {
      include('connect.php');

      $double = User::checkDoubleEmail($email);
      if($double == true) {
        return false;
      }

      $query = "UPDATE users
                SET email = ?
                WHERE user_id = $user_id";
      $stmt = mysqli_prepare($conn, $query);

      mysqli_stmt_bind_param($stmt, 's', $user_email);
      $user_email = $email;

      $result = mysqli_stmt_execute($stmt);

      mysqli_close($conn);
      return $result;
    }

    static function checkDoubleEmail($email) {
      include('connect.php');

      $query = "SELECT *
                FROM users
                WHERE email = ?";
      $stmt = mysqli_prepare($conn, $query);

      mysqli_stmt_bind_param($stmt, 's', $user_email);
      $user_email = $email;

      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);

      $row_count = mysqli_stmt_num_rows($stmt);

      if($row_count >= 1) {
        return true;
      } else {
        return false;
      }
    }

    static function updatePassword($user_id, $input_pass) {
      include('connect.php');

      $query = "UPDATE users
                SET password = ?
                WHERE user_id = $user_id";
      $stmt = mysqli_prepare($conn, $query);

      mysqli_stmt_bind_param($stmt, 's', $user_password);
      $user_password = password_hash($input_pass, PASSWORD_BCRYPT);

      $result = mysqli_stmt_execute($stmt);

      mysqli_close($conn);
      return $user_password;
    }

    static function createUserSuspension($userId) {
      include('../connect.php');

      $message = "You have been suspended!";
      $insertSuspension = "INSERT INTO 
                        suspensions(user_id, end_date, message)
                        VALUES ($userId, DATE_ADD(NOW(), INTERVAL 7 DAY), '$message')";
                      
      $query = mysqli_query($conn, $insertSuspension);

      return $query ? true : false;

    }

    static function changeSuspension($userId, $status) {
      include('../connect.php');

      $changeStatus = "UPDATE users u
                       SET u.suspended = '$status'
                       WHERE u.user_id = $userId";

      $query = mysqli_query($conn, $changeStatus);

      return $query ? true : false;
    }

    static function changeActive($userId, $status) {
      include('../connect.php');

      $changeActive = "UPDATE users u
                       SET u.active = '$status'
                       WHERE u.user_id = $userId";

      $query = mysqli_query($conn, $changeActive);

      return $query ? true : false;
    }
    
    static function changeRole($userId, $role) {
      include('../connect.php');
      
      $changeRole = "UPDATE users u
                     SET u.role = '$role' 
                     WHERE u.user_id = $userId";
  
      $query = mysqli_query($conn, $changeRole);

      return $query ? true : false;
    }

    public static function getUsers($count) {
      include('connect.php');

      $query = "SELECT user_id, CONCAT(fname, ' ', lname) as `name`, image, last_login
                FROM users
                WHERE role = 'user'
                ORDER BY user_id DESC
                LIMIT $count;";
        
      $result = mysqli_query($conn, $query);
      
      $users = array();

      if(mysqli_num_rows($result) > 0) {
        while($user = mysqli_fetch_assoc($result)) {
          array_push($users, $user);
        }
      }

      return $users;
    }

    public static function verifySettings($user_id, $input_pass) {
      include('connect.php');
      
      $query = "SELECT password
                FROM users
                WHERE user_id = $user_id;";

      $result = mysqli_query($conn, $query);

      $row = mysqli_fetch_assoc($result);
      $rpass = $row['password'];
      return password_verify($input_pass, $rpass);
    }
  }

?>