<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) { 
    case 'create-pending-listings-list': echo json_encode(createPendingListings()); break;
    case 'approve-pending-listing': echo json_encode(approvedListing()); break;
    case 'reject-pending-listing': echo json_encode(rejectedListing()); break;
  }

  //  CREATING A PENDING LISTING TAB
  function createPendingListings() {
    include('../connect.php');

    $applications = array();

    $pendingListingsInfo = "SELECT *
                            FROM listing_application la
                            WHERE la.listing_status = 'pending'";

    $query = mysqli_query($conn, $pendingListingsInfo);

    if (mysqli_num_rows($query) > 0) {
      while ($data = mysqli_fetch_assoc($query)) {
        $application_details = array();
        $application_details['application'] = $data;
        $application_details['categories'] = getListingCategory($data['application_id']);
        $application_details['variation'] = getListingVariation($data['application_id']);

        array_push($applications, $application_details);
      }
    }
    return $applications;
  }

  //  FETCHING CATEGORY DATA
  function getListingCategory($application_id) {
    include('../connect.php');

    $categories = array();

    $selectCategory = "SELECT listing_category_id
                       FROM listing_categories
                       WHERE application_id = $application_id";
    
    $query = mysqli_query($conn, $selectCategory);

    if (mysqli_num_rows($query) > 0) {
      while ($data = mysqli_fetch_assoc($query)) {
        $category_id = $data['listing_category_id'];
        
        $selectProdCategory = "SELECT category_name
                               FROM product_category
                               WHERE category_id = $category_id";

        $category = mysqli_fetch_assoc(mysqli_query($conn, $selectProdCategory));
        array_push($categories, $category['category_name']);
      }
    }
    return $categories;
  }

  //  FETCHING VARIATION DATA
  function getListingVariation($application_id) {
    include('../connect.php');

    $variations = array();

    $selectVariation = "SELECT variation
                        FROM listing_variations
                        WHERE application_id = $application_id";

    $query = mysqli_query($conn, $selectVariation);

    if (mysqli_num_rows($query) > 0) {
      while ($data = mysqli_fetch_assoc($query)) {
        array_push($variations, $data['variation']);
      }
    }
    return $variations;
  }

  //  APPROVAL OF LISTING (creating product works, cannot get product_id)
  function approvedListing() {
    include('../connect.php');
    include('../products/product.php');

    $details = $_REQUEST['applicationDetails'];
    $application = $details['application'];
    $result = Product::updateApplicationStatus($application['application_id'], 'approved');
    $result = Product::createProduct($application);
    $product_id = mysqli_insert_id($conn);
    $result = Product::createCategory($application['application_id'], $product_id);
    $result = Product::createVariations($application['application_id'], $product_id);

    return $result == true ? true : false;
  }

  //  REJECTION OF LISTING (complete)
  function rejectedListing() {
    include('../connect.php');
    include('../products/product.php');

    $details = $_REQUEST['applicationDetails'];
    $application = $details['application'];
    $result = Product::updateApplicationStatus($application['application_id'], 'rejected');

    return $result == true ? true : false;
  }

?>