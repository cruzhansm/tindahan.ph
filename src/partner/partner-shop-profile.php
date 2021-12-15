<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>tindahan.ph - Shop Profile</title>

  <link rel="icon" type="image/png" href="../../assets/images/tph-logo-128px.png" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://kit.fontawesome.com/056f419e6a.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/base/base.css" />
  <link rel="stylesheet" href="../../css/components/components.css" />
  <link rel="stylesheet" href="../../css/utilities/utilities.css" />
  <link rel="stylesheet" href="../../css/partner/partner.css" />

  <script src="../../js/common/auth/logout.js"></script>
  <script type="module" src="../../js/partner/shop-profile/modal.js"></script>
  <script type="module" src="../../js/partner/shop-profile/shop-profile.js"></script>
  <script type="module" src="/tindahan.ph/js/common/search.js"></script>
</head>

<body class="bg-primary">
  <div class="modal fade" id="editProfile" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable shop-modal-dialog">
      <div class="modal-content shop-modal-content">
        <div class="shop-modal-header" data-bs-dismiss="modal" onclick="dismissModal(editProfile)">
          <i class="fa-solid fa-x"></i>
        </div>
        <form onsubmit="attemptEditProfile(window.event)">
          <div class="modal-body shop-modal-body">
            <div class="shop-modal-body-form mx-auto">
              <div class="shop-modal-form-title">edit profile</div>
              <div class="shop-modal-form-upload for-validation">
                <img id="previewImg" class="shop-modal-form-img" />
                <label class="shop-modal-form-icon">
                  <i class="fa-solid fa-plus"></i>
                  <input id="partnerImg" accept="image/*" type="file" class="not-required" />
                </label>
              </div>
              <div class="shop-modal-form">
                <div class="for-validation">
                  <label for="partnerName" class="form-control">store name</label>
                  <input id="partnerName" type="text" class="form-control no-success" />
                </div>

                <div class="shop-modal-form-desc for-validation">
                  <label for="editProfileMsg" class="form-control" style="
                        color: var(--tph-text-secondary);
                        margin-bottom: 20px;
                      ">short description</label>
                  <textarea id="editProfileMsg" cols="30" rows="9" class="form-control no-success" maxlength="200"></textarea>
                  <div class="character-count-area">
                    <span id="editProfileMsgCount">0</span>
                    <span> / </span>
                    <span class="charLimit">200</span>
                  </div>
                </div>
                <div class="for-validation">
                  <label for="partnerCity" class="form-control">city</label>
                  <select name="city" id="partnerCity" class="form-select form-control">
                    <option selected>select a city</option>
                    <option value="Cebu City">Cebu City</option>
                    <option value="Lapu-Lapu City">Lapu-Lapu City</option>
                    <option value="Mandaue City">Mandaue City</option>
                  </select>
                  <!-- <input
                      id="partnerCity"
                      type="text"
                      class="form-control no-success"
                    /> -->
                </div>
                <div class="for-validation">
                  <label for="partnerBarangay" class="form-control">
                    barangay
                  </label>
                  <input id="partnerBarangay" type="text" class="form-control no-success" />
                </div>
                <label for="partnerContact" class="form-control">
                  contact number (10 digits)
                </label>
                <div class="form-contact-number for-validation">
                  <input id="partnerContact" type="number" maxlength="10" minlength="10" class="form-control no-success" />
                  <span class="form-control-number prefix">+63</span>
                </div>
              </div>
              <div class="shop-modal-button-group">
                <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal" onclick="dismissModal(editProfile)">
                  Cancel
                </button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row m-0">
    <div class="col left">
      <div class="sidenav">
        <div class="sidenav-header">
          <img src="../../assets/images/tph-logo-512px.png" class="sidenav-header-img" />
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
          <a id="storeo" href="#" class="sidenav-link active">
            <i class="fa-solid fa-shop sidenav-link-icon"></i>
            <div class="sidenav-link-text">Shop Profile</div>
          </a>
          <a href="../../src/partner/partner-add-listing.php" class="sidenav-link">
            <i class="fa-solid fa-circle-plus sidenav-link-icon"></i>
            <div class="sidenav-link-text">Add Listing</div>
          </a>
          <a href="../../src/partner/partner-orders.php" class="sidenav-link">
            <i class="fa-solid fa-receipt sidenav-link-icon"></i>
            <div class="sidenav-link-text">Orders</div>
          </a>
        </div>
      </div>
    </div>
    <div class="col right">
      <div class="container-display">
        <header class="header">
          <form onsubmit="search(event)">
            <input type="search" class="form-control form-search border-input" placeholder="Search products">
          </form>
          <div class="header-icons">
            <i class="fa-solid fa-gear"></i>
            <div class="user-image-icon" onclick="displayUserActions()">
              <img src="<?php echo $_SESSION['image'] ?>" class="user-image-icon" />
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
      </div>

      <div class="container-shop-banner">
        <div class="shop-banner">
          <img id="shopImg" class="shop-banner-img circle" />
          <div class="shop-banner-info">
            <div class="shop-banner-header">
              <div id="shopName" class="shop-banner-name fs-24"></div>
            </div>
            <div id="shopDesc" class="shop-banner-description"></div>
            <div class="shop-banner-actions">
              <div class="shop-banner-action">
                <i class="fa-solid fa-location-dot"></i>
                <span id="shopAddress"></span>
              </div>
              <div class="shop-banner-action">
                <i class="fa-solid fa-phone-flip"></i>
                <span id="shopContact"></span>
              </div>
            </div>
            <button id="edit" type="button" class="shop-banner-edit visually-hidden" onclick="showModal(editProfile)">
              Edit Profile
            </button>
          </div>
        </div>
      </div>

      <div id="aproducts" class="product-title title-sibling">
        All Products
      </div>

      <div id="paginationPages"></div>
      <nav id="paginationContainer" class="pagination-container"></nav>
    </div>
  </div>

  <div class="copyright mx-auto">
    <a href="src/common/about-us.html">about tindahan.ph</a>
    <div class="text-secondary">
      &copy 2021 tindahan.ph. All Rights Reserved.
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>