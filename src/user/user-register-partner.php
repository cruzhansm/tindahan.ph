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
  <title>tindahan.ph - Be a Partner</title>

  <link rel="icon" type="image/png" href="../../assets/images/tph-logo-128px.png" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://kit.fontawesome.com/056f419e6a.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/base/base.css" />
  <link rel="stylesheet" href="../../css/components/components.css" />
  <link rel="stylesheet" href="../../css/utilities/utilities.css" />
  <link rel="stylesheet" href="../../css/user/user.css" />
  <link rel="stylesheet" href="/tindahan.ph/css/common/common.css">
  <link rel="stylesheet" href="/tindahan.ph/css/common/settings/settings.css" />

  <script src="../../js/common/auth/logout.js"></script>
  <script type="module" src="../../js/user/register-partner.js"></script>
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
            <div class="fw-bolder">tindahan.ph</div>
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
          <a href="../../src/common/help-center.html" class="sidenav-link">
            <i class="fa-solid fa-headset sidenav-link-icon"></i>
            <div class="sidenav-link-text">Help Center</div>
          </a>
          <a href="#" class="sidenav-link active">
            <i class="fa-solid fa-handshake sidenav-link-icon"></i>
            <div class="sidenav-link-text">Be a Partner</div>
          </a>
        </div>
      </div>
    </div>
    <div class="col right">
      <div class="container-display">
        <header class="header">
          <form action="noSubmit(event)">
            <input type="search" class="form-control form-search border-input visually-hidden" placeholder="Search products" />
          </form>
          <div class="header-icons">
            <i class="fa-solid fa-gear" onclick="showSettings(verifySettings)"></i>
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

      <div class="container-register register-prompt visually-hidden">
        <div class="register-hero">
          <div class="register-hero-header">
            <div class="register-hero-bold">start a tindahan with us</div>
            <img src="../../assets/images/user/be-a-partner.svg" class="register-hero-img" />
          </div>
          <div class="register-hero-message">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Alias,
            accusamus maxime? Sed, et nostrum placeat deleniti porro aliquid
            corrupti illum repudiandae molestiae delectus omnis voluptatem?
          </div>
          <button class="btn btn-primary" onclick="showRegisterForm()">
            Be a partner
          </button>
        </div>
      </div>

      <div class="container-register register-form visually-hidden">
        <form onsubmit="attemptPartnerRegistration(event)">
          <div class="fs-30 text-highlight fw-bold text-center">
            Be a Partner
          </div>
          <div class="for-validation">
            <input id="storeName" type="text" class="form-control no-success" placeholder="shop name" />
          </div>
          <div class="register-form-categories">
            <label for="categ" class="form-control">What do you mainly sell?</label>
            <select id="categ" class="form-select">
              <option value="Category">Category</option>
              <option value="Food">Food</option>
              <option value="Cosmetics">Cosmetics</option>
              <option value="Furniture">Furniture</option>
              <option value="Women's">Women's</option>
              <option value="Men's">Men's</option>
              <option value="Jewelry">Jewelry</option>
              <option value="Electronic">Electronics</option>
              <option value="Kids">Kids</option>
              <option value="Stationery">Stationery</option>
            </select>
          </div>
          <div class="register-form-status">
            <label class="form-control">Are you new to online selling?</label>
            <div class="for-validation">
              <div class="register-form-radio">
                <div class="input-group">
                  <input name="onlineSelling" id="yesNewSell" type="radio" class="form-check-input" value="no" checked />
                  <label for="yesNewSell" class="form-control">Yes</label>
                </div>
                <div class="input-group">
                  <input name="onlineSelling" id="noNewSell" type="radio" class="form-check-input" value="yes" />
                  <label for="noNewSell" class="form-control">No</label>
                </div>
              </div>
            </div>
            <div class="register-form-platforms">
              <label for="platforms" class="form-control">If not, what are the other online selling platforms that you
                use?</label>
              <div class="for-validation disabled">
                <input id="platforms" type="text" class="form-control no-success" placeholder="online selling platforms" />
              </div>
            </div>
          </div>

          <div class="register-form-input-desc">
            <label for="shdesc" class="form-control">Short description of shop (Max of 200 characters)</label>
            <div class="for-validation" style="width: 100%">
              <div class="register-form-textarea">
                <textarea id="shdesc" cols="30" rows="10" class="form-control no-success" maxlength="200"></textarea>
                <div class="character-count-area">
                  <span class="character-count" id="shdescMsgCount">0</span>
                  <span> / </span>
                  <span class="charLimit">200</span>
                </div>
              </div>
            </div>
          </div>

          <div class="register-form-upload">
            <label class="form-control">Shop picture or logo (Max <span id="fileLimit">1</span>)</label>
            <div class="register-form-custom-upload">
              <img alt="preview" id="previewImg" class="preview-image visually-hidden" />
            </div>
            <label class="btn btn-primary custom-upload">
              Upload
              <input type="file" accept="image/*" required />
            </label>
          </div>

          <button type="submit" class="btn btn-primary mx-auto">
            Send application
          </button>
        </form>
      </div>

      <div class="container-register register-process visually-hidden">
        <div class="register-process-hero">
          <div class="fs-30 text-highlight fw-bold">Be a Partner</div>
          <img src="../../assets/images/user/be-a-partner-review.svg" />
          <div class="fs-18 text-secondary">
            Your application is currently in review.
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
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>