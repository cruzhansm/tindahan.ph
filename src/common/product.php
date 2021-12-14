<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title id="productPageTitle">tindahan.ph - Product Name Here</title>

    <link
      rel="icon"
      type="image/png"
      href="../../assets/images/tph-logo-128px.png"
    />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
      integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script
      src="https://kit.fontawesome.com/056f419e6a.js"
      crossorigin="anonymous"
    ></script>

    <link rel="stylesheet" href="../../css/base/base.css" />
    <link rel="stylesheet" href="../../css/components/components.css" />
    <link rel="stylesheet" href="../../css/utilities/utilities.css" />
    <link rel="stylesheet" href="../../css/common/common.css" />

    <script src="../../js/common/auth/logout.js"></script>
    <script
      type="module"
      src="../../js/common/products/product-page.js"
    ></script>
  </head>

  <body class="bg-primary">
    <div class="row m-0">
      <div class="col left">
        <div class="sidenav">
          <div class="sidenav-header">
            <img
              src="../../assets/images/tph-logo-512px.png"
              class="sidenav-header-img"
            />
            <div class="sidenav-header-text">
              <div>tindahan.ph</div>
              <?php 
                if(strcmp($_SESSION['role'], 'user') != 0) { 
                  echo '<div>' . strtoupper($_SESSION['role']) . '
            </div>
            ' ; } ?>
          </div>
        </div>

        <div class="sidenav-links">
          <?php

          if($_SESSION['role'] == 'partner') {
            echo '
              <a href="/tindahan.ph/index.php" class="sidenav-link">
                <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
                <div class="sidenav-link-text">Home</div>
              </a>
              <a href="../../src/common/categories.php" class="sidenav-link">
                <i class="fa-solid fa-cubes sidenav-link-icon"></i>
                <div class="sidenav-link-text">Categories</div>
              </a>
              <a
                href="../../src/partner/partner-shop-profile.php"
                class="sidenav-link"
              >
                <i class="fa-solid fa-shop sidenav-link-icon"></i>
                <div class="sidenav-link-text">Shop Profile</div>
              </a>
              <a
                href="../../src/partner/partner-add-listing.html"
                class="sidenav-link"
              >
                <i class="fa-solid fa-circle-plus sidenav-link-icon"></i>
                <div class="sidenav-link-text">Add Listing</div>
              </a>
              <a href="../../src/partner/partner-orders.php" class="sidenav-link">
                <i class="fa-solid fa-receipt sidenav-link-icon"></i>
                <div class="sidenav-link-text">Orders</div>
              </a>
            ';
          }
          else if($_SESSION['role'] == 'user') {
            echo '<a href="/tindahan.ph/index.php" class="sidenav-link">
              <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
              <div class="sidenav-link-text">Home</div>
            </a>
            <a href="../../src/common/categories.php" class="sidenav-link">
              <i class="fa-solid fa-cubes sidenav-link-icon"></i>
              <div class="sidenav-link-text">Categories</div>
            </a>
            <a href="../../src/user/user-cart.php" class="sidenav-link">
              <i class="fa-solid fa-cart-shopping sidenav-link-icon"></i>
              <div class="sidenav-link-text">Cart</div>
            </a>
            <a href="../../src/user/user-purchases.php" class="sidenav-link">
              <i class="fa-solid fa-bag-shopping sidenav-link-icon"></i>
              <div class="sidenav-link-text">My Purchases</div>
            </a>
            <a
              href="../../src/user/user-register-partner.php"
              class="sidenav-link"
            >
              <i class="fa-solid fa-handshake sidenav-link-icon"></i>
              <div class="sidenav-link-text">Be a Partner</div>
            </a>';
          }
          else {
            echo '<div class="sidenav-links">
              <a href="/tindahan.ph/src/admin/admin-dashboard.php" class="sidenav-link active">
                <i class="fa-solid fa-tachometer-alt sidenav-link-icon"></i>
                <div class="sidenav-link-text">Dashboard</div>
              </a>
              <a href="/tindahan.ph/src/admin/admin-users.php" class="sidenav-link">
                <i class="fa-solid fa-users-cog sidenav-link-icon"></i>
                <div class="sidenav-link-text">Users</div>
              </a>
              <a href="/tindahan.ph/src/admin/admin-partners.php" class="sidenav-link">
                <i class="fa-solid fa-hands-helping sidenav-link-icon"></i>
                <div class="sidenav-link-text">Partners</div>
              </a>
              <a href="/tindahan.ph/src/admin/admin-live-listings.php" class="sidenav-link">
                <i class="fa-solid fa-list-alt sidenav-link-icon"></i>
                <div class="sidenav-link-text">Live Listings</div>
              </a>';
          }
          ?>
        </div>
      </div>
    </div>

    <div class="col right">
      <div class="container-display">
        <header class="header">
          <form action="noSubmit(event)">
            <input
              type="search"
              class="form-control form-search border-input"
              placeholder="Search products"
            />
          </form>
          <div class="header-icons">
            
            <i class="fa-solid fa-gear"></i>
            <div class="user-image-icon" onclick="displayUserActions()">
              <div class="user-image-actions visually-hidden">
                <div class="user-image-action no-hover">
                  <i class="fa-solid fa-user"></i>
                  <div><?php echo $_SESSION['fname']; ?></div>
                </div>
                <div class="user-image-action">
                  <i class="fa-solid fa-right-from-bracket"></i>
                  <span onclick="logout()">LOG OUT</span>
                </div>
              </div>
            </div>
          </div>
        </header>
      </div>

      <div class="container-product-page">
        <div class="container-product-area">
          <img class="product-img" id="productImg" />
          <div class="product-formal">
            <div class="product-info">
              <div class="product-info-inline">
                <div class="fs-30 fw-bold" id="productName"></div>
                <div class="product-info-price" id="productPrice"></div>
              </div>
              <div class="product-info-rating">
                <i class="fa-solid fa-star"></i>
                <span id="productRating"></span>
                <span> | </span>
                <span id="productRatingCount"></span>
                <span> ratings</span>
              </div>
              <a id="productStore" class="fs-18 text-highlight"></a>
              <div id="productCategories" class="product-info-category">
                <div>Category:</div>
              </div>
              <div id="productBrand"></div>
            </div>
            <div class="product-info-variation">
              <select
                name="variation"
                id="productVariation"
                class="form-select"
                >
                <option value="NULL" selected>No variation</option>
            </select>
            </div>
            <div id="inStock" class="product-purchase-area visually-hidden">
              <div class="product-purchase-quantity">
                <span>Quantity</span>
                <div class="product-purchase-quantity quantity-actions">
                  <i id="minus" class="fa-solid fa-circle-minus"></i>
                  <span id="buyCount">1</span>
                  <i id="plus" class="fa-solid fa-circle-plus"></i>
                </div>
                <span
                  id="productQuantity"
                  class="product-purchase-quantity quantity-stock"
                ></span>
              </div>
              <div class="product-actions-row">
                <button class="btn btn-primary product-purchase-button " onclick="attemptAddToCart()">
                  Add to Cart
                </button>
                <button class="btn btn-tertiary edit visually-hidden" onclick="redirectToEdit()">Edit</button>
              </div>
            </div>
            <div
              id="outStock"
              class="product-purchase-area out-stock visually-hidden"
            >
              <div class="product-purchase-quantity">
                <span>Quantity</span>
                <div
                  class="product-purchase-quantity quantity-actions disabled"
                >
                  <i id="minus" class="fa-solid fa-circle-minus"></i>
                  <span id="buyCount">0</span>
                  <i id="plus" class="fa-solid fa-circle-plus"></i>
                </div>
                <span
                  id="productQuantity"
                  class="product-purchase-quantity quantity-stock"
                  >0 pieces left</span
                >
              </div>
              <div class="product-actions-row">
                <button class="btn btn-tertiary disabled product-purchase-button ">
                  Out of Stock
                </button>
                <button class="btn btn-tertiary edit visually-hidden" onclick="redirectToEdit()">Edit</button>
              </div>
            </div>
          </div>
        </div>

        <div class="container-product-description">
          <div class="fs-24">Product Description</div>
          <div id="productDesc" class="product-page-description"></div>
        </div>

        <div class="container-product-reviews">
          <div class="fs-24">Product Ratings</div>

          <div class="product-reviews-formal">
            <div class="product-reviews-rating">
              <i class="fa-solid fa-star"></i>
              <div class="product-reviews-rating total-rating">
                <span id="productRating" class="fs-36">0.0</span>
                <span>out of 5</span>
              </div>
            </div>
            <div class="product-reviews-rating-filter">
              <button
                class="btn btn-tertiary product-reviews-rating filter-button"
              >
                <i class="fa-solid fa-filter"></i>
                Filter
              </button>
            </div>
          </div>

          <div class="product-page-reviews populated">
            <div id="noReviews" class="fs-18 text-secondary visually-hidden">
              No ratings yet
            </div>
            
            <!-- THIS IS THE CONTAINER FOR THE PAGINATION PAGES -->
            <!-- YOU CAN ADD ANY CLASS TO THE DIV, SO LONG AS YOU -->
            <!-- GIVE IT THE SAME ID AS THE ONE HERE -->
            <div id="paginationPages" class="product-page-review-list"></div>

            <!-- THIS IS THE CONTAINER FOR THE PAGINATION ITSELF -->
            <!-- PLEASE USE THE SAME ID HERE AS WELL FOR YOUR OWN -->
            <!-- PAGINATION. USE THE SAME AS WELL, OR FEEL FREE TO STYLE IT -->
            <nav id="paginationContainer" class="pagination-container"></nav>
          </div>
        </div>
      </div>
    </div>
    </div>

    <div class="copyright mx-auto">
      <a href="src/common/about-us.html">about tindahan.ph</a>
      <div class="text-secondary">
        &copy 2021 tindahan.ph. All Rights Reserved.
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
