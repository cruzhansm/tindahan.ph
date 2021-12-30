<?php

  session_start();

  $type = $_REQUEST['type'];

  switch($type) { 
    case 'create-pending-listings-list': echo json_encode(createPendingListings()); break;
    case 'approve-pending-listing': echo json_encode(approvedListing()); break;
    case 'reject-pending-listing': echo json_encode(rejectedListing()); break;
    case 'insert-new-listing': echo json_encode(newListing()); break;
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

    $selectCategory = "SELECT category_id
                       FROM listing_categories
                       WHERE application_id = $application_id";
    
    $query = mysqli_query($conn, $selectCategory);

    if (mysqli_num_rows($query) > 0) {
      while ($data = mysqli_fetch_assoc($query)) {
        $category_id = $data['category_id'];
        
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

    $application_id = $_REQUEST['applicationID'];
    $result = Product::updateApplicationStatus($application_id, 'approved');
    
    $product_id = Product::createProduct($application_id);

    $result = Product::createCategory($application_id, $product_id);
    $result = Product::createVariations($application_id, $product_id);

    return $result;
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

  function newListing() {
    include('../connect.php');
    include('../partner/store.php');

    $application = json_decode($_REQUEST['application'], MYSQLI_ASSOC);
    
    $user = $_SESSION['user_id'];

    $store = new PartnerStore($user);
    $vibes = $store->jsonSerialize();

    $query = "INSERT INTO listing_application(listing_store, listing_name, listing_img, listing_price, listing_desc, listing_brand, listing_quantity)
              VALUES(?, ?, ?, ?, ?, ?, ?);";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ississi', 
                           $listing_store,
                           $listing_name,
                           $listing_img,
                           $listing_price,
                           $listing_desc,
                           $listing_brand,
                           $listing_quantity);
                           
    $listing_store = $vibes['store_id'];
    $listing_name = $application['listingName'];
    $listing_img = $application['listingImg'];
    $listing_price = $application['listingPrice'];
    $listing_desc = $application['listingDesc'];
    $listing_brand = $application['listingBrand'];
    $listing_quantity = $application['listingQuantity'];

    $result = mysqli_stmt_execute($stmt);

    $application_id = mysqli_insert_id($conn);
    
    $listing_categ = $application['listingCateg'];

    $query = "INSERT INTO listing_categories (application_id, category_id)
              VALUES($application_id, $listing_categ);";

    $result = mysqli_query($conn, $query);

    $listing_variations = $application['listingVariations'];

    foreach($listing_variations as $variation) {
      $query2 = "INSERT INTO listing_variations(application_id, variation, price, quantity)
                 VALUES(?, ?, ?, ?);";

      $stmt2 = mysqli_prepare($conn, $query2);

      mysqli_stmt_bind_param($stmt2, 'isii',
                             $application,
                             $variation_name,
                             $variation_price,
                             $variation_quantity);
      $application = $application_id;
      $variation_name = $variation['name'];
      $variation_price = $variation['price'];
      $variation_quantity = $variation['stock'];

      $result = mysqli_stmt_execute($stmt2);
    }

    return $result;
  }

?>