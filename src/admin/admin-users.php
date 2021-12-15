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
    <title>tindahan.ph - User Management</title>

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
    <link rel="stylesheet" href="../../css/admin/admin.css" />

    <script
      src="../../js/admin/admin-modals/user-modals/suspend-user-modal.js"
      type="module"
    ></script>
    <script
      src="../../js/admin/admin-modals/user-modals/delete-user-modal.js"
      type="module"
    ></script>
    <script src="../../js/admin/user-management.js" type="module"></script>
    <script src="../../js/common/auth/logout.js"></script>
  </head>

  <body class="bg-primary">
    <div
      class="modal fade"
      id="suspendModal"
      data-bs-backdrop="static"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-scrollable shop-modal-dialog">
        <div class="modal-content admin listing-modal-content">
          <div class="modal-body suspend-modal-body admin">
            <!--  DISPLAY DATA HERE -->
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="deleteModal"
      data-bs-backdrop="static"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-scrollable shop-modal-dialog">
        <div class="modal-content listing-modal-content admin">
          <div class="modal-body delete-modal-body admin">
            <!--  DISPLAY DATA HERE -->
          </div>
        </div>
      </div>
    </div>

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
              <div>ADMIN</div>
            </div>
          </div>
          <div class="sidenav-links">
            <a href="./admin-dashboard.php" class="sidenav-link">
              <i class="fa-solid fa-tachometer-alt sidenav-link-icon"></i>
              <div class="sidenav-link-text">Dashboard</div>
            </a>
            <a href="#" class="sidenav-link active">
              <i class="fa-solid fa-users-cog sidenav-link-icon"></i>
              <div class="sidenav-link-text">Users</div>
            </a>
            <a href="./admin-partners.php" class="sidenav-link">
              <i class="fa-solid fa-hands-helping sidenav-link-icon"></i>
              <div class="sidenav-link-text">Partners</div>
            </a>
            <a href="./admin-live-listings.php" class="sidenav-link">
              <i class="fa-solid fa-list-alt sidenav-link-icon"></i>
              <div class="sidenav-link-text">Live Listings</div>
            </a>
          </div>
        </div>
      </div>
      <div class="col right">
        <div class="container-display">
        <header class="header">
          <div class="text-highlight fw-bold">Overview</div>
          <div class="header-icons">
          <i class="fa-solid fa-gear"></i>
            <div  onclick="displayUserActions()">
            <img src="<?php echo $_SESSION['image']?>" class="user-image-icon" />
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

          <div class="container-admin-user">
            <!-- <form class="container-admin-user-header">
            <input
              type="search"
              class="form-control form-search admin-user-search"
              placeholder="Search"
            />
            <div class="admin-user-inline-search">
              <span>Filters:</span>
              <div class="input-group">
                <input
                  name="filterUser"
                  id="partners"
                  type="checkbox"
                  class="form-check-input"
                />
                <label for="partners" class="form-check">Partners</label>
              </div>
              <div class="input-group">
                <input
                  name="filterUser"
                  id="users"
                  type="checkbox"
                  class="form-check-input"
                />
                <label for="users" class="form-check">Users</label>
              </div>
              <div class="input-group">
                <input
                  name="filterUser"
                  id="suspended"
                  type="checkbox"
                  class="form-check-input"
                />
                <label for="suspended" class="form-check">Suspended</label>
              </div>
              <div class="input-group">
                <input
                  name="filterUser"
                  id="banned"
                  type="checkbox"
                  class="form-check-input"
                />
                <label for="banned" class="form-check">Banned</label>
              </div>
            </div>
          </form> -->

            <div class="container-admin-user-list" id="admin-user-list">
              <!--  INSERT DATA HERE  -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="copyright mx-auto">
      <div class="text-highlight">about tindahan.ph</div>
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
