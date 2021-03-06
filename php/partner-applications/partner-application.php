<?php
  class PartnerApplication {
    private $user_id;
    private $store_name;
    private $store_categ;
    private $store_desc;
    private $store_img;
    private $store_experience;
    private $store_platforms;

    function __construct($user_id, $store_name, $store_categ, $store_desc, $store_img, $store_experience, $store_platforms) {
      $this->user_id = $user_id;
      $this->store_name = $store_name;
      $this->store_categ = $store_categ;
      $this->store_desc = $store_desc;
      $this->store_img = $store_img;
      $this->store_experience = $store_experience;
      $this->store_platforms = $store_platforms;
    }

    function insertApplication() {
      include('../connect.php');

      $query = "INSERT INTO partner_applications (user_id, store_name, store_main_categ, store_desc, store_img, online_experience, online_platforms) VALUES (?, ?, ?, ?, ?, ?, ?);";

      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, 'issssss', 
                             $user_id,
                             $store_name,
                             $store_categ,
                             $store_desc,
                             $store_img,
                             $store_experience,
                             $store_platforms);

      $user_id = $this->user_id;
      $store_name = $this->store_name;
      $store_categ = $this->store_categ;
      $store_desc = $this->store_desc;
      $store_img = $this->store_img;
      $store_experience = $this->store_experience;
      $store_platforms = $this->store_platforms;
      
      $result = mysqli_stmt_execute($stmt);

      mysqli_close($conn);

      return $result;
    }

    static function userHasApplied($user_id) {
      include('../connect.php');

      $query = "SELECT * 
                FROM partner_applications 
                WHERE user_id = $user_id;";
      
      $result = mysqli_query($conn, $query);

      return mysqli_num_rows($result) > 0 ? true : false;
    }

    // Updates status of partner application (complete)
    static function changeStatus($application_id, $status) {
      include('../connect.php');
      include('../error.php');

      $changeStatus = "UPDATE partner_applications pa
                       SET pa.application_status = '$status'
                       WHERE pa.application_id = $application_id";
              
      $query = mysqli_query($conn, $changeStatus);

      return $query ? true : new CustomError("Update Error: ", "Status not changed");
    }

    public static function getApplications($count) {
      include('../connect.php');

      $query = "SELECT pa.application_id, pa.store_img, pa.store_name, CONCAT(u.fname, ' ', u.lname) AS `name`
                FROM partner_applications pa
                JOIN users u ON u.user_id = pa.user_id
                WHERE pa.application_status = 'pending'
                ORDER BY pa.application_id DESC
                LIMIT $count";

      $result = mysqli_query($conn, $query);

      $applications = array();

      if(mysqli_num_rows($result) > 0) {
        while($application = mysqli_fetch_assoc($result)) {
          array_push($applications, $application);
        }
      }

      return $applications;
    }
  } 
?>