<?php

session_start();

include '../connect.php';
// echo "1";

if (isset($_POST['publish'])) {
  // echo "2";
  $id = $_SESSION['user_id'];
  // $id = 2;

  $find_id = "SELECT * FROM partner_store WHERE `user_id` = '$id'";
  $query = mysqli_query($conn, $find_id);

  if ($query) {
    // echo "3";
    if (mysqli_num_rows($query) > 0) {
      // echo "4";
      if ($row = mysqli_fetch_assoc($query)) {
        // echo "5";
        $store_id = $row['store_id'];

        $img = $_FILES['img'];
        $file_name = $_FILES['img']['name'];
        // $file_ext = strtolower(end(explode('.', $file_name)));
        $file_size = $_FILES['img']['size'];
        $file_tmp = $_FILES['img']['tmp_name'];
        $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
        $data = file_get_contents($file_tmp);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $name = $_POST['name'];
        $price = $_POST['price'];
        $desc = $_POST['desc'];
        $brand = $_POST['brand'];

        $listing = "INSERT INTO `listing_application`
                    (`listing_store`, `listing_img`, `listing_name`, `listing_price`, `listing_desc`, `listing_brand`) 
                    VALUES ($store_id, '$base64', '$name', $price, '$desc', '$brand')";

        $query_list = mysqli_query($conn, $listing);
        // echo "6";

        $application_id = mysqli_insert_id($conn);

        $category = $_POST['category'];
        $listing = "INSERT INTO `listing_categories` (`application_id`, `category_id`) VALUES ($application_id ,'$category')";

        $query_list = mysqli_query($conn, $listing);
        // echo "7";

        if ($query_list) {
          // echo "8";
          header("location: ../../src/partner/partner-add-listing.php");
        }
      }
    }
  }
}
