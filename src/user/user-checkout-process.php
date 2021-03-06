<?php
session_start();

if (!isset($_SESSION['user_id'])) {
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
  <title>tindahan.ph - Checkout</title>

  <link rel="icon" type="image/png" href="../../assets/images/tph-logo-128px.png" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://kit.fontawesome.com/056f419e6a.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="/tindahan.ph/css/common/common.css">
  <link rel="stylesheet" href="/tindahan.ph/css/common/settings/settings.css" />
  <link rel="stylesheet" href="../../css/base/base.css" />
  <link rel="stylesheet" href="../../css/components/components.css" />
  <link rel="stylesheet" href="../../css/utilities/utilities.css" />
  <link rel="stylesheet" href="../../css/partner/orders/orders.css" />
  <link rel="stylesheet" href="../../css/user/user.css" />

  <script src="../../js/common/auth/logout.js"></script>
  <script type="module" src="../../js/user/checkout-process.js"></script>
  <script type="module" src="/tindahan.ph/js/common/settings/settings.js"></script>
</head>

<body class="bg-primary">
  <!--SETTINGS MODAL-->
  <div class="modal fade" id="verifySettings" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="verify-settings-modal modal-content modal-dialog">
      <div class="verify-settings-modal-header" data-bs-dismiss="modal" onclick="dismissModal(verifySettings)">
        <i class="fa-solid fa-x"></i>
      </div>
      <form onsubmit="attemptAccessSettings(event)" id="verify-settings" class="verify-settings-form form-dismiss">
        <label class="form-control account-label">enter password to access settings</label>
        <div class="for-validation">
          <input type="password" placeholder="password" id="verify-settings-input" class="form-control form-password border-input" required />
        </div>
        <button type="submit" class="btn btn-primary border-content">confirm</button>
      </form>
    </div>
  </div>
  <!-- MODAL CONTENT -->
  <div class="modal fade" id="settingsModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="settings-modal-content modal-content settings-dialog modal-dialog modal-dialog-centered modal-dialog-scrollable settings">
      <!-- MODAL TABS -->
      <div class="modal-tabs">
        <ul class="nav nav-tabs settings-tabs" id="nav-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" onclick="openInfo()" id="profile-tab" data-bs-toggle="tab" data-bs-target="#infoSettings" type="button" role="tab" aria-controls="infoSettings" aria-selected="true">Profile</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" onclick="openAccount()" id="account-tab" data-bs-toggle="tab" data-bs-target="#accountSettings" type="button" role="tab" aria-controls="accountSettings" aria-selected="false">Account</button>
          </li>
        </ul>
      </div>
      <div class="tab-content settings-tab-content" id="nav-tabContent">
        <!-- EDIT PROFILE -->
        <div class="tab-pane fade show active" id="infoSettings" role="tabpanel" aria-labelledby="profile-tab">
          <div class="profile-modal-header" data-bs-dismiss="modal" onclick="dismissSettingsModal(settingsModal)">
            <i class="fa-solid fa-x"></i>
          </div>
          <div class="modal-body profile-modal-body">
            <div class="profile-modal-body-form mx-auto">
              <div class="profile-modal-form-title">edit info</div>
              <form onsubmit="attemptUpdateInfo(event)" class="not-required profile-modal-form" id="info-settings">
                <div class="profile-modal-form-upload for-validation">
                  <img id="previewImg" class="profile-modal-form-img" />
                  <label class="profile-modal-form-icon">
                    <i class="fa-solid fa-plus"></i>
                    <input id="partnerImg" accept="image/*" type="file" class="not-required" />
                  </label>
                </div>
                <div class="profile-modal-input-group">
                  <div class="for-validation">
                    <label for="" class="form-control">first name</label>
                    <input id="user-fName" type="text" class="no-success not-required form-control">
                  </div>
                  <div class="for-validation">
                    <label for="" class="form-control">last name</label>
                    <input id="user-lName" type="text" class="no-success not-required form-control">
                  </div>

                  <label for="" class="form-control">city</label>
                  <select name="city" id="user-city" class="form-select form-control">
                    <option selected>select a city</option>
                    <option value="Cebu City">Cebu City</option>
                    <option value="Lapu-Lapu City">Lapu-Lapu City</option>
                    <option value="Mandaue City">Mandaue City</option>
                  </select>

                  <div class="for-validation">
                    <label for="" class="form-control">barangay</label>
                    <input type="text" id="user-barangay" class="no-success not-required form-control">
                  </div>
                  <div class="for-validation">
                    <label for="" class="form-control">street</label>
                    <input type="text" id="user-street" class="no-success not-required form-control">
                  </div>
                  <div class="for-validation">
                    <label for="" class="form-control">zipcode</label>
                    <input type="number" maxlength="4" minlength="4" id="user-zipcode" class="no-success not-required form-control">
                  </div>
                  <div class="for-validation">
                    <label for="" class="form-control">landmark</label>
                    <input type="text" id="user-landmark" class="no-success not-required form-control">
                  </div>
                  <label for="" class="form-control">contact number</label>
                  <div class="form-contact-number for-validation">
                    <input type="number" maxlength="10" minlength="10" id="user-contact" class="no-success not-required form-control">
                    <span class="form-control-number prefix">+63</span>
                  </div>
                </div>
                <div class="profile-modal-button-group">
                  <button type="button" class="btn btn-tertiary" data-bs-dismiss="modal" onclick="dismissSettingsModal(settingsModal)">Cancel</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- ACCOUNT TAB -->
        <div class="tab-pane fade account-modal" id="accountSettings" role="tabpanel" aria-hidden="true" aria-labelledby="account-tab">
          <div class="account-modal-header" data-bs-dismiss="modal" onclick="dismissSettingsModal(settingsModal)">
            <i class="fa-solid fa-x"></i>
          </div>
          <!-- ACCOUNT DATA -->
          <div class="account-data" id="accountData">
            <div class="account-item" onclick="changeEmail()">
              <div class="account-item-detail">
                <p>Change Email</p>
                <p class="account-email" id="accountUserEmail"></p>
              </div>
              <div class="account-redirect">
                <i class="fas fa-chevron-right"></i>
              </div>
            </div>
            <div class="account-item" onclick="changePassword()">
              <div class="account-item-detail">
                <p>Change Password</p>
              </div>
              <div class="account-redirect">
                <i class="fas fa-chevron-right"></i>
              </div>
            </div>
          </div>
          <!-- ACCOUNT NEW PASSWORD -->
          <div class="account-new-password account-forms visually-hidden" id="newPassword">
            <form onsubmit="attemptUpdatePassword(event)">
              <label class="form-control account-label">enter new password</label>
              <div class="for-validation">
                <input type="password" placeholder="password" id="updatePassword" class="form-control border-input form-password" required>
              </div>
              <label class="form-control account-label">confirm password</label>
              <div class="for-validation">
                <input type="password" placeholder="confirm password" id="updateConPassword" class="form-control border-input form-password" required>
              </div>
              <button type="submit" class="btn btn-primary border-content">update</button>
            </form>
          </div>
          <!-- ACCOUNT NEW EMAIL -->
          <div class="account-new-email account-forms visually-hidden" id="newEmail">
            <form onsubmit="attemptUpdateEmail(event)">
              <div class="for-validation">
                <label class="form-control account-label">enter new email</label>
                <input type="email" placeholder="email" id="inputNewEmail" class="form-control border-input" required>
              </div>
              <button type="submit" class="btn btn-primary border-content">update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- MODAL CONTENT ENDS -->
  <div class="row m-0">
    <div class="col left">
      <div class="sidenav">
        <div class="sidenav-header">
          <img src="../../assets/images/tph-logo-512px.png" class="sidenav-header-img" />
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
          <a href="../../src/user/user-cart.php" class="sidenav-link">
            <i class="fa-solid fa-cart-shopping sidenav-link-icon"></i>
            <div class="sidenav-link-text">Cart</div>
          </a>
          <a href="../../src/user/user-purchases.php" class="sidenav-link">
            <i class="fa-solid fa-bag-shopping sidenav-link-icon"></i>
            <div class="sidenav-link-text">My Purchases</div>
          </a>

          <a href="../../src/user/user-register-partner.php" class="sidenav-link">
            <i class="fa-solid fa-handshake sidenav-link-icon"></i>
            <div class="sidenav-link-text">Be a Partner</div>
          </a>
        </div>
      </div>
    </div>
    <div class="col right">
      <div class="container-display">
        <header class="header">
          <div class="text-highlight fw-bold">Checkout</div>
          <div class="header-icons">
            <i class="fa-solid fa-gear" onclick="showSettings(verifySettings)"></i>
            <div  onclick="displayUserActions()">
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

        <div class="container-checkout-progress mx-auto">
          <div class="checkout-progress">
            <div class="checkout-progress-step done">1</div>
            <div class="checkout-progress-process">Form</div>
          </div>
          <div class="checkout-progress-bar"></div>
          <div class="checkout-progress">
            <div class="checkout-progress-step">2</div>
            <div class="checkout-progress-process">Summary</div>
          </div>
          <div class="checkout-progress-bar"></div>
          <div class="checkout-progress">
            <div class="checkout-progress-step">3</div>
            <div class="checkout-progress-process">Payment</div>
          </div>
          <div class="checkout-progress-bar"></div>
          <div class="checkout-progress">
            <div class="checkout-progress-step">4</div>
            <div class="checkout-progress-process">Done</div>
          </div>
        </div>

        <div class="container-checkout-process mx-auto">
          <div class="container-checkout-process-title">information form</div>
          <form id="checkoutInfo" onsubmit="proceedToSummary(event)" class="checkout-process-form">
            <div class="for-validation">
              <input id="recipientFname" type="text" class="form-control no-success" />
            </div>
            <div class="for-validation">
              <input id="recipientLname" type="text" class="form-control no-success" />
            </div>
            <div class="form-contact-number for-validation checkout">
              <input id="recipientContact" type="number" maxlength="10" minlength="10" placeholder="contact number" class="form-control no-success" />
              <span class="form-control-number prefix">+63</span>
            </div>
            <div class="for-validation">
              <input id="recipientStreet" type="text" class="form-control no-success" placeholder="floor/unit/room/street" />
            </div>
            <div class="inline-form">
              <select name="" id="recipientCity" class="form-select">
                <option value="Cebu City">Cebu City</option>
                <option value="Lapu-Lapu CLapu-Lapu">City</option>
                <option value="Mandaue City">Mandaue City</option>
              </select>
              <div class="for-validation">
                <input id="recipientBrgy" type="text" class="form-control no-success" />
              </div>
            </div>
            <div class="inline-form">
              <div class="for-validation">
                <input id="recipientLandmark" type="text" class="form-control no-success" placeholder="landmark" />
              </div>
              <div class="for-validation">
                <input id="recipientZipcode" type="number" maxlength="4" minlength="4" class="form-control no-success" placeholder="zipcode" />
              </div>
            </div>
            <div class="container-button-group information">
              <button type="button" class="btn btn-tertiary" onclick="redirectPreviousURL()">
                Cancel
              </button>
              <button type="submit" class="btn btn-primary">Proceed</button>
            </div>
          </form>
        </div>

        <div class="container-checkout-process mx-auto visually-hidden">
          <div class="container-checkout-process-title">order summary</div>
          <div class="container-orders">
            <div class="orders-group"></div>
          </div>

          <div class="checkout-summary">
            <div class="checkout-voucher-area">
              <div class="for-validation">
                <input type="text" id="orderVoucher" class="form-control" maxlength="15" placeholder="voucher code" />
              </div>
              <button type="button" class="btn btn-primary" onclick="verifyValidVoucher()">
                Apply
              </button>
            </div>
            <div class="checkout-summary-detail">
              <div class="checkout-summary-calculations">
                <div class="checkout-summary-costs">
                  <div>Subtotal</div>
                  <div>Shipping Fee</div>
                  <div>Voucher</div>
                </div>
                <div class="checkout-summary-prices">
                  <div id="orderSubtotal"></div>
                  <div id="orderDelivery"></div>
                  <div id="orderVoucherOff">-P0</div>
                </div>
              </div>
              <div class="checkout-summary-total">
                <div class="checkout-summary-costs">
                  <div>TOTAL</div>
                </div>
                <div class="checkout-summary-prices">
                  <div id="orderTotalPrice"></div>
                </div>
              </div>
            </div>
            <div class="container-button-group">
              <button class="btn btn-tertiary" onclick="proceedToInformation()">
                Back
              </button>
              <button class="btn btn-primary" onclick="proceedToPayment()">
                Proceed
              </button>
            </div>
          </div>
        </div>

        <div class="container-checkout-process mx-auto visually-hidden">
          <div class="container-checkout-process-title">payment method</div>
          <form id="payment" onsubmit="proceedToFinalStep(event)" class="checkout-process-form">
            <div class="input-group">
              <input id="cod" name="paymentMethod" type="radio" class="form-check-input" checked />
              <label for="cod" class="form-check-label">Cash on Delivery (COD)</label>
            </div>
            <div class="input-group">
              <input id="cc" name="paymentMethod" type="radio" class="form-check-input" />
              <label for="cc" class="form-check-label">Credit Card</label>
            </div>

            <div id="ccform" class="checkout-process-payment visually-hidden">
              <label for="email" class="form-control">email</label>
              <div class="for-validation">
                <input id="email" type="email" class="form-control" placeholder="enter email" />
              </div>
              <label for="ccnum" class="form-control">card number</label>
              <div class="for-validation">
                <input id="ccnum" type="number" class="form-control" minlength="16" maxlength="16" placeholder="enter card number" />
              </div>

              <div class="checkout-process-payment-inline">
                <div class="checkout-payment-expiry">
                  <label for="ccdetails" class="form-control">expiry date</label>
                  <div class="checkout-payment-expiry-fields">
                    <div class="for-validation">
                      <input type="number" class="form-control" id="ccdetails" placeholder="MM" min="1" max="12" minlength="1" maxlength="2" />
                    </div>
                    <div>/</div>
                    <div class="for-validation">
                      <input type="number" minlength="2" maxlength="2" class="form-control" id="ccdetails" placeholder="YY" />
                    </div>
                  </div>
                </div>
                <div class="for-validation checkout-payment-cvv">
                  <label for="cccvv" class="form-control">CVV</label>
                  <input id="cccvv" type="number" min="000" max="9999" minlength="3" maxlength="4" class="form-control" />
                </div>
              </div>
            </div>

            <div class="container-button-group cod">
              <button type="button" class="btn btn-tertiary" onclick="proceedBackToSummary()">
                Back
              </button>
              <button type="submit" class="btn btn-primary">Proceed</button>
            </div>
          </form>
        </div>

        <div class="container-checkout-process mx-auto visually-hidden">
          <div class="container-checkout-done">
            <img src="../../assets/images/user/order-successful.svg" alt="Order success!" class="checkout-process-done-img" />
            <div class="checkout-process-done-status">
              <div class="fs-24 text-highlight fw-bold">order successful</div>
              <div class="fs-18 text-secondary fw-bold">
                Your order is being processed.
              </div>
            </div>
            <div class="checkout-process-done-msg">
              head over to My Purchases for updates on your order
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>