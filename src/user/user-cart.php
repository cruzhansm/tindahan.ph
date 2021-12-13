<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>tindahan.ph - My Cart</title>

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
    <link rel="stylesheet" href="../../css/user/user.css" />

    <script src="../../js/common/auth/logout.js"></script>
    <script type="module" src="/tindahan.ph/js/user/user-cart.js"></script>
  </head>

  <body class="bg-primary">
    <div
      class="modal fade"
      id="productRemove"
      data-bs-backdrop="static"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="modal-dialog remove-product">
        <div class="modal-content remove-product">
          <div class="modal-body remove-product">
            Are you sure you want to delete this item from your shopping cart?
          </div>
          <div class="modal-footer remove-product">
            <button id="delete" type="button" class="btn btn-highlight">
              Delete
            </button>
            <button
              id="cancel"
              type="button"
              class="btn modal-cancel-btn remove-product"
              data-bs-dismiss="modal"
              onclick="dismissModal(productRemove)"
            >
              Cancel
            </button>
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
            <a href="#" class="sidenav-link active">
              <i class="fa-solid fa-cart-shopping sidenav-link-icon"></i>
              <div class="sidenav-link-text">Cart</div>
            </a>
            <a href="../../src/user/user-purchases.php" class="sidenav-link">
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
        </div>
      </div>
      <div class="col right">
        <div class="container-display cart">
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

          <div class="container-cart">
            <div class="container-form">
              <div class="cart-form-group cart-select">
                <div class="cart-form-header">
                  <div class="cart-form-checkbox">
                    <div class="form-check">
                      <input
                        type="checkbox"
                        class="form-check-input"
                        id="selectAll"
                      />
                      <label for="selectAll" class="form-check-label">
                        Select all
                      </label>
                    </div>
                  </div>
                  <div class="cart-form-titles">
                    <span>Unit Price</span>
                    <span>Quantity</span>
                    <span>Total Price</span>
                  </div>
                  <div class="cart-form-delete"></div>
                </div>
              </div>
            </div>

            <div class="checkout">
              <div class="container-checkout">
                <div class="cart-checkout-total">
                  <span>Total</span>
                  <span class="text-highlight fw-bold" id="totalCart">P0</span>
                </div>
                <button
                  class="btn btn-primary cart-checkout-btn"
                  onclick="attemptCheckout()"
                >
                  Check out
                </button>
              </div>
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
