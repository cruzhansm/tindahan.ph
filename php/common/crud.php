<?php

session_start();

$request = $_REQUEST['type'];

switch ($request) {
  case ('retrieve-categories'):
    echo json_encode(retrieveCategories());
    break;
  case ('title'):
    echo retrieveTitle();
    break;
  case ('products-results'):
    echo json_encode(retrieveProducts());
    break;
  case ('retrieve-user-info'):
    echo json_encode(retrieveUserInfo());
    break;
  case ('validate-settings'):
    echo json_encode(validateSettings());
    break;
  case ('initialize-info'):
    echo json_encode(initializeInfo());
    break;
  case ('get-user-details'):
    echo json_encode(getUserDetails());
    break;
  case ('update-user-info'):
    echo json_encode(updateUserInfo());
    break;
  case ('update-email'):
    echo json_encode(updateEmail());
    break;
  case ('update-password'):
    echo json_encode(updatePassword());
    break;
  case ('search'):
    echo json_encode(searchQuery());
    break;
}

function retrieveCategories()
{
  include_once('../connect.php');

  $categories = array();
  $query = 'SELECT * FROM product_category';
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    while ($data = mysqli_fetch_assoc($result)) {
      $categories[] = $data;
    }
  }
  return $categories;
}

function retrieveTitle()
{
  include_once('../connect.php');
  $category_id = $_REQUEST['id'];

  $query = "SELECT category_name
              FROM product_category
              WHERE category_id = '$category_id'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    return $data['category_name'];
  }
}

function retrieveProducts()
{
  include_once('../connect.php');
  include_once('../products/product.php');
  $category = $_REQUEST['category'];

  $products = array();
  $result = array();
  $products = Product::fetchByCategoryID($category);

  foreach ($products as $x) {
    $data = new Product($x);
    array_push($result, $data);
  }
  return $result;
}

function retrieveUserInfo()
{
  include_once('../connect.php');
}

function validateSettings()
{
  include_once('../connect.php');
  include_once('../user.php');

  $pass = $_REQUEST['pass'];
  $user_id  = $_SESSION['user_id'];

  return User::verifySettings($user_id, $pass);
}

function initializeInfo()
{
  include_once('../connect.php');
  include_once('../user.php');
  $user_id  = $_SESSION['user_id'];
  return User::getUserInfo($user_id);
}

function getUserDetails()
{
  include_once('../connect.php');
  $user_id  = $_SESSION['user_id'];

  $query = "SELECT *
            FROM users
            WHERE user_id = '$user_id'";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_assoc($result);
  return $data;
}

function updateUserInfo()
{
  include_once('../connect.php');
  include('../error.php');
  include_once('../user.php');
  include_once('../common/user-address.php');

  $updateInfo = json_decode($_REQUEST['updateDetails'], MYSQLI_ASSOC);
  $user_id = $_SESSION['user_id'];

  $result = User::updateUserInfo($updateInfo, $user_id);
  $result = UserAddress::updateUserAddress($updateInfo, $user_id);

  return $result ? true : new CustomError(error: 'Input', error_msg: 'One or more fields has an invalid input.');
}

function updateEmail()
{
  include_once('../connect.php');
  include('../error.php');
  include_once('../user.php');

  $user_id = $_SESSION['user_id'];
  $email = $_REQUEST['newEmail'];

  $result = User::updateEmail($user_id, $email);

  return $result ? true : new CustomError(error: 'Input', error_msg: 'ERROR: Email is already in use.');
}

function updatePassword()
{
  include_once('../connect.php');
  include('../error.php');
  include_once('../user.php');

  $user_id = $_SESSION['user_id'];
  $pass = $_REQUEST['newPass'];

  $result = User::updatePassword($user_id, $pass);
  // return $result;
  return $result ? true : new CustomError(error: 'Input', error_msg: 'Invalid input.');
}

function searchQuery() 
{
  include_once('../connect.php');
  include_once('../products/product.php');

  $user_query = $_REQUEST['search_query'];

  $products = array();
  $result = array();
  
  $products = Product::fetchBySearchQuery($user_query);

  foreach ($products as $x) {
    $data = new Product($x);
    array_push($result, $data);
  }
  return $result;
}
