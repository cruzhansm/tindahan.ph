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
    <title>tindahan.ph - My Purchases</title>

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
    <link rel="stylesheet" href="../../css/user/cart/cart-modal.css" />
    <link rel="stylesheet" href="../../css/user/purchases/purchases.css" />
    <link
      rel="stylesheet"
      href="../../css/common/help-center/help-center-modal.css"
    />
    <link rel="stylesheet" href="/tindahan.ph/css/common/common.css" />
    <link
      rel="stylesheet"
      href="/tindahan.ph/css/common/settings/settings.css"
    />

    <script src="../../js/common/auth/logout.js"></script>
    <script type="module" src="../../js/user/user-purchases.js"></script>
    <!-- <script
      type="module"
      src="/tindahan.ph/js/common/settings/settings.js"
    ></script> -->
    <script type="module" src="/tindahan.ph/js/common/search.js"></script>
  </head>

  <body class="bg-primary">
    <!--SETTINGS MODAL-->
    <div
      class="modal fade"
      id="verifySettings"
      data-bs-backdrop="static"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="verify-settings-modal modal-content modal-dialog">
        <div
          class="verify-settings-modal-header"
          data-bs-dismiss="modal"
          onclick="dismissModal(verifySettings)"
        >
          <i class="fa-solid fa-x"></i>
        </div>
        <form
          onsubmit="attemptAccessSettings(event)"
          id="verify-settings"
          class="verify-settings-form form-dismiss"
        >
          <label class="form-control account-label"
            >enter password to access settings</label
          >
          <div class="for-validation">
            <input
              type="password"
              placeholder="password"
              id="verify-settings-input"
              class="form-control form-password border-input"
              required
            />
          </div>
          <button type="submit" class="btn btn-primary border-content">
            confirm
          </button>
        </form>
      </div>
    </div>
    <!-- MODAL CONTENT -->
    <div
      class="modal fade"
      id="settingsModal"
      data-bs-backdrop="static"
      tabindex="-1"
      aria-hidden="true"
    >
      <div
        class="
          settings-modal-content
          modal-content
          settings-dialog
          modal-dialog modal-dialog-centered modal-dialog-scrollable
          settings
        "
      >
        <!-- MODAL TABS -->
        <div class="modal-tabs">
          <ul class="nav nav-tabs settings-tabs" id="nav-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button
                class="nav-link active"
                onclick="openInfo()"
                id="profile-tab"
                data-bs-toggle="tab"
                data-bs-target="#infoSettings"
                type="button"
                role="tab"
                aria-controls="infoSettings"
                aria-selected="true"
              >
                Profile
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button
                class="nav-link"
                onclick="openAccount()"
                id="account-tab"
                data-bs-toggle="tab"
                data-bs-target="#accountSettings"
                type="button"
                role="tab"
                aria-controls="accountSettings"
                aria-selected="false"
              >
                Account
              </button>
            </li>
          </ul>
        </div>
        <div class="tab-content settings-tab-content" id="nav-tabContent">
          <!-- EDIT PROFILE -->
          <div
            class="tab-pane fade show active"
            id="infoSettings"
            role="tabpanel"
            aria-labelledby="profile-tab"
          >
            <div
              class="profile-modal-header"
              data-bs-dismiss="modal"
              onclick="dismissSettingsModal(settingsModal)"
            >
              <i class="fa-solid fa-x"></i>
            </div>
            <div class="modal-body profile-modal-body">
              <div class="profile-modal-body-form mx-auto">
                <div class="profile-modal-form-title">edit info</div>
                <form
                  onsubmit="attemptUpdateInfo(event)"
                  class="not-required profile-modal-form"
                  id="info-settings"
                >
                  <div class="profile-modal-form-upload for-validation">
                    <img
                      style="border-radius: 50%"
                      id="previewImg"
                      class="profile-modal-form-img"
                    />
                    <label class="profile-modal-form-icon">
                      <i class="fa-solid fa-plus"></i>
                      <input
                        id="partnerImg"
                        accept="image/*"
                        type="file"
                        class="not-required"
                      />
                    </label>
                  </div>
                  <div class="profile-modal-input-group">
                    <div class="for-validation">
                      <label for="" class="form-control">first name</label>
                      <input
                        id="user-fName"
                        type="text"
                        class="no-success not-required form-control"
                      />
                    </div>
                    <div class="for-validation">
                      <label for="" class="form-control">last name</label>
                      <input
                        id="user-lName"
                        type="text"
                        class="no-success not-required form-control"
                      />
                    </div>

                    <label for="" class="form-control">city</label>
                    <select
                      name="city"
                      id="user-city"
                      class="form-select form-control"
                    >
                      <option selected>select a city</option>
                      <option value="Cebu City">Cebu City</option>
                      <option value="Lapu-Lapu City">Lapu-Lapu City</option>
                      <option value="Mandaue City">Mandaue City</option>
                    </select>

                    <div class="for-validation">
                      <label for="" class="form-control">barangay</label>
                      <input
                        type="text"
                        id="user-barangay"
                        class="no-success not-required form-control"
                      />
                    </div>
                    <div class="for-validation">
                      <label for="" class="form-control">street</label>
                      <input
                        type="text"
                        id="user-street"
                        class="no-success not-required form-control"
                      />
                    </div>
                    <div class="for-validation">
                      <label for="" class="form-control">zipcode</label>
                      <input
                        type="number"
                        maxlength="4"
                        minlength="4"
                        id="user-zipcode"
                        class="no-success not-required form-control"
                      />
                    </div>
                    <div class="for-validation">
                      <label for="" class="form-control">landmark</label>
                      <input
                        type="text"
                        id="user-landmark"
                        class="no-success not-required form-control"
                      />
                    </div>
                    <label for="" class="form-control">contact number</label>
                    <div class="form-contact-number for-validation">
                      <input
                        type="number"
                        maxlength="10"
                        minlength="10"
                        id="user-contact"
                        class="no-success not-required form-control"
                      />
                      <span class="form-control-number prefix">+63</span>
                    </div>
                  </div>
                  <div class="profile-modal-button-group">
                    <button
                      type="button"
                      class="btn btn-tertiary"
                      data-bs-dismiss="modal"
                      onclick="dismissSettingsModal(settingsModal)"
                    >
                      Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- ACCOUNT TAB -->
          <div
            class="tab-pane fade account-modal"
            id="accountSettings"
            role="tabpanel"
            aria-hidden="true"
            aria-labelledby="account-tab"
          >
            <div
              class="account-modal-header"
              data-bs-dismiss="modal"
              onclick="dismissSettingsModal(settingsModal)"
            >
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
            <div
              class="account-new-password account-forms visually-hidden"
              id="newPassword"
            >
              <form onsubmit="attemptUpdatePassword(event)">
                <label class="form-control account-label"
                  >enter new password</label
                >
                <div class="for-validation">
                  <input
                    type="password"
                    placeholder="password"
                    id="updatePassword"
                    class="form-control border-input form-password"
                    required
                  />
                </div>
                <label class="form-control account-label"
                  >confirm password</label
                >
                <div class="for-validation">
                  <input
                    type="password"
                    placeholder="confirm password"
                    id="updateConPassword"
                    class="form-control border-input form-password"
                    required
                  />
                </div>
                <button type="submit" class="btn btn-primary border-content">
                  update
                </button>
              </form>
            </div>
            <!-- ACCOUNT NEW EMAIL -->
            <div
              class="account-new-email account-forms visually-hidden"
              id="newEmail"
            >
              <form onsubmit="attemptUpdateEmail(event)">
                <div class="for-validation">
                  <label class="form-control account-label"
                    >enter new email</label
                  >
                  <input
                    type="email"
                    placeholder="email"
                    id="inputNewEmail"
                    class="form-control border-input"
                    required
                  />
                </div>
                <button type="submit" class="btn btn-primary border-content">
                  update
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL CONTENT ENDS -->
    <div
      class="modal fade"
      id="orderCancel"
      data-bs-backdrop="static"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content remove-product">
          <div class="modal-body remove-product">
            Are you sure you want to cancel this order?
          </div>
          <div class="modal-footer remove-product"></div>
        </div>
      </div>
    </div>

    <div
      class="modal"
      id="productReview"
      data-bs-backdrop="static"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="modal-dialog help-center">
        <div class="modal-content help-center">
          <div class="modal-header help-center">
            <h5 class="modal-title help-center">How was the product?</h5>
          </div>
          <form class="form-modal">
            <div class="modal-body help-center">
              <div class="purchase-product-rating">
                <i class="fa-solid fa-star"></i>
                <select
                  name="prating"
                  id="productRatingSelect"
                  class="form-select"
                >
                  <option value="0">Rating</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
              <div class="for-validation">
                <div class="form-textarea">
                  <textarea
                    id="productReviewMsg"
                    cols="30"
                    rows="10"
                    maxlength="250"
                    class="form-control no-success not-required"
                    placeholder="Type your message here"
                  ></textarea>
                  <div class="character-count-area">
                    <span id="productReviewMsgCount">0</span>
                    <span> / </span>
                    <span class="charLimit">250</span>
                  </div>
                </div>
              </div>
              <div class="register-form-upload purchases">
                <div class="register-form-custom-upload">
                  <span>No file chosen</span>
                  <label class="btn btn-primary custom-upload">
                    Upload
                    <input
                      id="reviewImages"
                      type="file"
                      accept="image/*"
                      multiple
                    />
                  </label>
                </div>
              </div>
            </div>
            <div class="modal-footer help-center"></div>
          </form>
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
            <a href="#" class="sidenav-link active">
              <i class="fa-solid fa-bag-shopping sidenav-link-icon"></i>
              <div class="sidenav-link-text">My Purchases</div>
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
        <div class="container-display">
          <header class="header product">
            <form onsubmit="search(event)">
              <input
                type="search"
                class="form-control form-search border-input"
                placeholder="Search products"
              />
            </form>
            <div class="header-icons">
              <i
                class="fa-solid fa-gear"
                onclick="showSettings(verifySettings)"
              ></i>
              <div onclick="displayUserActions()">
                <img
                  src="<?php echo $_SESSION['image'] ?>"
                  class="user-image-icon"
                />
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

          <div class="fs-24 text-highlight fw-bold mx-3 mb-5">
            Purchase History
          </div>

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
                    id="all"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                    checked
                  />
                  <label for="all" class="form-check-label">All</label>
                </div>
                <div class="order-filter-type">
                  <input
                    id="confirmation"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="confirmation" class="form-check-label"
                    >To Confirm</label
                  >
                </div>
                <div class="order-filter-type">
                  <input
                    id="processing"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="processing" class="form-check-label"
                    >To Ship</label
                  >
                </div>
                <div class="order-filter-type">
                  <input
                    id="shipped"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="processing" class="form-check-label"
                    >To Deliver</label
                  >
                </div>
                <div class="order-filter-type">
                  <input
                    id="transit"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="transit" class="form-check-label"
                    >To Receive</label
                  >
                </div>
                <div class="order-filter-type">
                  <input
                    id="delivered"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="delivered" class="form-check-label"
                    >Delivered</label
                  >
                </div>
                <div class="order-filter-type">
                  <input
                    id="cancelled"
                    type="radio"
                    name="filter"
                    class="form-check-input"
                  />
                  <label for="cancelled" class="form-check-label"
                    >Cancelled</label
                  >
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
