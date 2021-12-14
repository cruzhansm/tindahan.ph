<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>tindahan.ph - Orders</title>

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
    <link rel="stylesheet" href="../../css/partner/partner.css" />

    <script src="../../js/common/auth/logout.js"></script>
    <script
      type="module"
      src="../../js/partner/orders/partner-orders.js"
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
              <div>PARTNER</div>
            </div>
          </div>
          <div class="sidenav-links">
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
              href="../../src/partner/partner-add-listing.php"
              class="sidenav-link"
            >
              <i class="fa-solid fa-circle-plus sidenav-link-icon"></i>
              <div class="sidenav-link-text">Add Listing</div>
            </a>
            <a href="#" class="sidenav-link active">
              <i class="fa-solid fa-receipt sidenav-link-icon"></i>
              <div class="sidenav-link-text">Orders</div>
            </a>
            
          </div>
        </div>
      </div>
      <div class="col right">
        <div class="container-display">
          <header class="header product">
            <div class="text-highlight fw-bold">Orders</div>
            <div class="header-icons">
              
              <i class="fa-solid fa-gear"></i>
              <div class="user-image-icon" onclick="displayUserActions()">
                <div class="user-image-actions visually-hidden">
                  <div class="user-image-action no-hover">
                    <i class="fa-solid fa-user"></i>
                    <div><?php echo $_SESSION['fname'] ?></div>
                  </div>
                  <div class="user-image-action">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span onclick="logout()">LOG OUT</span>
                  </div>
                </div>
              </div>
            </div>
          </header>

          <div class="container-orders">
            <div class="container-orders-list">
              <div id="paginationPages" class="product-page-review-list"></div>
              <nav id="paginationContainer" class="pagination-container"></nav>
            </div>

            <div class="container-orders-filter">
              <div class="fs-24 text-highlight fw-bold">Filters</div>
              <form class="orders-filters">
                <div class="order-filter-type">
                  <input
                    value="all"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                    checked
                  />
                  <label for="" class="form-check-label">All</label>
                </div>
                <div class="order-filter-type">
                  <input
                    value="confirmation"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="" class="form-check-label">To Confirm</label>
                </div>
                <div class="order-filter-type">
                  <input
                    value="processing"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="" class="form-check-label">To Ship</label>
                </div>
                <div class="order-filter-type">
                  <input
                    value="shipped"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="" class="form-check-label">To Deliver</label>
                </div>
                <div class="order-filter-type">
                  <input
                    value="delivered"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="" class="form-check-label">Delivered</label>
                </div>
                <div class="order-filter-type">
                  <input
                    value="cancelled"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="" class="form-check-label">Cancelled</label>
                </div>
              </form>
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
