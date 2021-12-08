<?php
  session_start();

  if(!isset($_SESSION['user_id'])) {
    header('Location: /tindahan.ph/src/common/login.php?mode=login');
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>tindahan.ph - Categories</title>

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

    <script src="../../js/common/auto-resizer.js"></script>
    <script src="../../js/common/auth/logout.js"></script>
    <script src="../../js/common/categories-results.js"></script>
  </head>

  <script>
    new Promise(function (resolve, reject) {
      $.ajax({
        type: 'GET',
        url: '/tindahan.ph/php/utype.php',
        success: (result) => {
          resolve(result);
        },
      });
    }).then((resolve) => {
      const test = document.querySelector(`#${resolve}1`);
      const test2 = document.querySelector(`#${resolve}1`);

      test.classList.remove('visually-hidden');
      test2.classList.remove('visually-hidden');
    });
  </script>

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
              <div class="visually-hidden" id="partner2">PARTNER</div>
            </div>
          </div>
          <div class="sidenav-links visually-hidden" id="user1">
            <a href="../../index.php" class="sidenav-link">
              <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
              <div class="sidenav-link-text">Home</div>
            </a>
            <a href="#" class="sidenav-link active">
              <i class="fa-solid fa-cubes sidenav-link-icon"></i>
              <div class="sidenav-link-text">Categories</div>
            </a>
            <a href="../../src/user/user-cart.html" class="sidenav-link">
              <i class="fa-solid fa-cart-shopping sidenav-link-icon"></i>
              <div class="sidenav-link-text">Cart</div>
            </a>
            <a href="../../src/user/user-purchases.html" class="sidenav-link">
              <i class="fa-solid fa-bag-shopping sidenav-link-icon"></i>
              <div class="sidenav-link-text">My Purchases</div>
            </a>
            <a href="../../src/common/help-center.html" class="sidenav-link">
              <i class="fa-solid fa-headset sidenav-link-icon"></i>
              <div class="sidenav-link-text">Help Center</div>
            </a>
            <a
              href="../../src/user/user-register-partner.php"
              class="sidenav-link"
            >
              <i class="fa-solid fa-handshake sidenav-link-icon"></i>
              <div class="sidenav-link-text">Be a Partner</div>
            </a>
          </div>
          <div class="sidenav-links visually-hidden" id="partner1">
            <a href="../../index.php" class="sidenav-link">
              <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
              <div class="sidenav-link-text">Home</div>
            </a>
            <a
              href="../../src/common/categories.html"
              class="sidenav-link active"
            >
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
              href="../../src/partner//partner-add-listing.html"
              class="sidenav-link"
            >
              <i class="fa-solid fa-circle-plus sidenav-link-icon"></i>
              <div class="sidenav-link-text">Add Listing</div>
            </a>
            <a
              href="../../src/partner/partner-orders.html"
              class="sidenav-link"
            >
              <i class="fa-solid fa-receipt sidenav-link-icon"></i>
              <div class="sidenav-link-text">Orders</div>
            </a>
            <a href="../../src/common/help-center.html" class="sidenav-link">
              <i class="fa-solid fa-headset sidenav-link-icon"></i>
              <div class="sidenav-link-text">Help Center</div>
            </a>
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
              <i class="fa-solid fa-inbox"></i>
              <i class="fa-solid fa-gear"></i>
              <div class="user-image-icon" onclick="displayUserActions()">
                <div class="user-image-actions visually-hidden">
                  <div class="user-image-action no-hover">
                    <i class="fa-solid fa-user"></i>
                    <div>userFirstName</div>
                  </div>
                  <div class="user-image-action">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <a href="../../src/common/login.html">LOG OUT</a>
                  </div>
                </div>
              </div>
            </div>
          </header>
        </div>
        <div class="container-categories">
          <div class="product-title"></div>
          <div class="container-product-feed row row-cols-4 row-cols-md-4 g-4">

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
