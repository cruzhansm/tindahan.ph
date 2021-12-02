<?php
  session_start();

  if(!isset($_SESSION['user_id'])) {
    header('Location: /tindahan.ph/src/common/login.php');
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>tindahan.ph - Home</title>

  <link rel="icon" type="image/png" href="assets/images/tph-logo-128px.png" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://kit.fontawesome.com/056f419e6a.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="css/base/base.css">
  <link rel="stylesheet" href="css/components/components.css">
  <link rel="stylesheet" href="css/utilities/utilities.css">
  <link rel="stylesheet" href="css/home/home.css">
  <link rel="stylesheet" href="css/common/common.css">

  <script src="js/common/auto-resizer.js"></script>
  <script src="js/common/fetch-products.js"></script>
  <script src="js/common/search.js"></script>
  <script src="js/common/products.js"></script>
  <script src="js/common/messaging.js"></script>
  <script src="js/common/modal.js"></script>
  <script src="js/common/account-settings.js"></script>
  <script src="/tindahan.ph/js/common/auth/logout.js"></script>
</head>

<script>

  window.onload = () => { 
    fetchProductsByBatch(); 
    attachMessagingEventListener();
  }

</script>

<body class="bg-primary">
  <!-- MODAL CONTENT -->
  <div class="modal fade" id="settingsModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="settings-modal-content modal-content modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <!-- MODAL TABS -->
      <div class="modal-tabs">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
              type="button" role="tab" aria-controls="profile" aria-selected="true">Profile</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button"
              role="tab" aria-controls="account" aria-selected="false">Account</button>
          </li>
        </ul>
      </div>
      <div class="tab-content" id="myTabContent">
        <!-- EDIT PROFILE -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="profile-modal-header" data-bs-dismiss="modal" onclick="dismissModal(settingsModal)">
            <i class="fa-solid fa-x"></i>
          </div>
          <div class="modal-body profile-modal-body">
            <div class="profile-modal-body-form mx-auto">
              <div class="profile-modal-form-title">edit profile</div>
              <div class="profile-modal-form-upload">
                <div class="profile-modal-form-img"></div>
                <label class="profile-modal-form-icon">
                  <i class="fa-solid fa-plus"></i>
                  <input accept="image/*" type="file">
                </label>
              </div>
              <form onsubmit="" class="profile-modal-form">
                <label for="" class="form-control">partner name</label>
                <input id="partnerName" type="text" class="form-control">
                <div class="profile-modal-form-desc">
                  <label for="" class="form-control">short description</label>
                  <div class="profile-modal-form-count">
                    <span id="description">0</span>
                    <span> / </span>
                    <span>200</span>
                  </div>
                </div>
                <textarea id="profileDesc" cols="30" rows="9" class="form-control" maxlength="200"></textarea>
                <label for="" class="form-control">city</label>
                <input type="text" class="form-control">
                <label for="" class="form-control">barangay</label>
                <input type="text" class="form-control">
                <label for="" class="form-control">contact number</label>
                <div class="form-contact-number">
                  <input type="text" maxlength="11" class="form-control">
                  <span class="form-control-number prefix">+63</span>
                </div>
              </form>
              <div class="profile-modal-button-group">
                <button class="btn btn-tertiary" data-bs-dismiss="modal"
                  onclick="dismissModal(settingsModal)">Cancel</button>
                <button class="btn btn-primary" onclick="updateProfile()">Save</button>
              </div>
            </div>
          </div>
        </div>
        <!-- ACCOUNT TAB -->
        <div class="account-modal tab-pane fade" id="account" role="tabpanel" aria-hidden="true" aria-labelledby="account-tab">
          <div class="account-modal-header" data-bs-dismiss="modal" onclick="dismissModal(settingsModal)">
            <i class="fa-solid fa-x"></i>
          </div>
          <!--ACCOUNT PASSWORD VERIFY-->
          <div class="account-verify account-forms" id="account-verify">
            <label class="form-control account-label">enter your password to proceed</label>
            <div class="form-password border-input" id="account-settings-password">
              <input type="password" placeholder="password" class="form-control border-input password" required>
              <i class="fas fa-eye"></i>
            </div>
            <button class="btn btn-primary border-content" id="account-data-switch">confirm</button>
          </div>
          <!--ACCOUNT DATA-->
          <div class="account-data account-forms visually-hidden" id="account-data">
            <fieldset disabled>
              <div class="account-data-email">
                <label class="form-control account-label">email</label>
                <input type="email" class="form-control border-input">
                <span id="account-reverify-email-switch">change</span>
              </div>
              <div class="account-data-password">
                <label class="form-control account-label">password</label>
                <input type="text" class="form-control border-input password">
                <span id="account-reverify-password-switch">change</span>
              </div>
            </fieldset>
          </div>
          <!--ACCOUNT REVERIFY PASSWORD-->
          <div class="account-reverify-password account-forms visually-hidden" id="account-reverify-password">
            <label class="form-control account-label">re-enter your password</label>
            <div class="form-password border-input">
              <input type="password" placeholder="password" class="form-control border-input password" required>
              <i class="fas fa-eye"></i>
            </div>
            <button class="btn btn-primary border-content" id="account-update-password-switch">confirm</button>
          </div>
          <!--ACCOUNT REVERIFY EMAIL-->
          <div class="account-reverify-email account-forms visually-hidden" id="account-reverify-email">
            <label class="form-control account-label">re-enter your password</label>
            <div class="form-password border-input">
              <input type="password" placeholder="password" class="form-control border-input password" required>
              <i class="fas fa-eye"></i>
            </div>
            <button class="btn btn-primary border-content" id="account-update-email-switch">confirm</button>
          </div>
          <!--ACCOUNT NEW PASSWORD-->
          <div class="account-new-password account-forms visually-hidden" id="account-new-password">
            <label class="form-control account-label">enter new password</label>
            <div class="form-password border-input" id="account-settings-password">
              <input type="password" placeholder="password" class="form-control border-input password" required>
              <i class="fas fa-eye"></i>
            </div>
            <label class="form-control account-label">confirm password</label>
            <div class="form-password border-input" id="account-settings-password">
              <input type="password" placeholder="confirm password" class="form-control border-input password" required>
              <i class="fas fa-eye"></i>
            </div>
            <button class="btn btn-primary border-content" id="account-new-password-switch">update</button>
          </div>
          <!--ACCOUNT NEW EMAIL-->
          <div class="account-new-email account-forms visually-hidden" id="account-new-email">
            <div class="account-tab-data-email">
              <label class="form-control account-label">email</label>
              <input type="email" placeholder="email" class="form-control border-input">
            </div>
            <button class="btn btn-primary border-content" id="account-new-email-switch">update</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class="row m-0">
    <div class="col left">
      <div class="sidenav">
        <div class="sidenav-header">
          <img src="assets/images/tph-logo-512px.png" class="sidenav-header-img">
          <div class="sidenav-header-text">
            <div class="fw-bolder">tindahan.ph</div>
          </div>
        </div>
        <div class="sidenav-links">
          <a href="#" class="sidenav-link active">
            <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
            <div class="sidenav-link-text">Home</div>
          </a>
          <a href="src/common/categories.html" class="sidenav-link">
            <i class="fa-solid fa-cubes sidenav-link-icon"></i>
            <div class="sidenav-link-text">Categories</div>
          </a>
          <a href="src/user/user-cart.html" class="sidenav-link">
            <i class="fa-solid fa-cart-shopping sidenav-link-icon"></i>
            <div class="sidenav-link-text">Cart</div>
          </a>
          <a href="src/user/user-purchases.html" class="sidenav-link">
            <i class="fa-solid fa-bag-shopping sidenav-link-icon"></i>
            <div class="sidenav-link-text">My Purchases</div>
          </a>
          <a href="src/common/help-center.html" class="sidenav-link">
            <i class="fa-solid fa-headset sidenav-link-icon"></i>
            <div class="sidenav-link-text">Help Center</div>
          </a>
          <a href="src/user/user-register-partner.html" class="sidenav-link">
            <i class="fa-solid fa-handshake sidenav-link-icon"></i>
            <div class="sidenav-link-text">Be a Partner</div>
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
            <i class="fa-solid fa-inbox"></i>
            <i class="fa-solid fa-gear" onclick="showModal(settingsModal)"></i>
            <div class="user-image-icon" onclick="displayUserActions()">
              <div class="user-image-actions visually-hidden">
                <div class="user-image-action no-hover">
                  <i class="fa-solid fa-user"></i>
                  <div>userFirstName</div>
                </div>
                <div class="user-image-action">
                  <i class="fa-solid fa-right-from-bracket"></i>
                  <span onclick="logout()">LOG OUT</span>
                </div>
              </div>
            </div>
          </div>
        </header>

        <div class="container-carousel">
          <div class="container-home-carousel">
            <i class="carousel-control-prev fa-solid fa-chevron-left" data-bs-target="#homeCarousel"
              data-bs-slide="prev"></i>
            <div id="homeCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
              <div class="carousel-inner">
                <img src="assets/images/home-banner-1.png" class="carousel-item active">
                </img>
                <img src="assets/images/home-banner-2.png" class="carousel-item">
                </img>
                <img src="assets/images/home-banner-3.png" class="carousel-item">
                </img>
              </div>
            </div>
            <i class="carousel-control-next fa-solid fa-chevron-right" type="button" data-bs-target="#homeCarousel"
              data-bs-slide="next"></i>
          </div>
        </div>

        <div class="product-title">Daily Discover</div>

        <div class="container-product-feed row row-cols-4 row-cols-md-4 g-4">
        </div>
      </div>
    </div>
  </div>

  <!-- TODO -->
  <!-- 1. Convert to Object -->
  <!-- 2. Define JS that automatically appends the messages object to page -->
  <div class="container-messages visually-hidden">
    <div class="messages-header">
      <div class="messages-header-title">messages</div>
      <button class="btn btn-primary" style="width: max-content; height: max-content; padding: 5px; line-height: 10px; font-size: 10px;" onclick="noConvos()">Click for no active convo</button>
      <button class="btn btn-primary" style="width: max-content; height: max-content; padding: 5px; line-height: 10px; font-size: 10px;" onclick="normalConvos()">Click for normal convo</button>
      <button class="btn btn-primary" style="width: max-content; height: max-content; padding: 5px; line-height: 10px; font-size: 10px;" onclick="attachmentSentZ()">Click for attachment sent only</button>
      <i class="fa-solid fa-x messages-header-close" onclick="hideMessages()"></i>
    </div>
    <div class="container-messages-content">
      <div class="container-messages-chat">
        <div id="chatNoActive" class="d-flex justify-content-center align-items-center h-100 w-100 flex-column gap-3">
          <i class="fa-solid fa-comments text-secondary" style="font-size: 100px;"></i>
          <div class="fs-18 text-secondary">Start a conversation</div>
        </div>

        <div id="chatHide" class="message-chat-input-area visually-hidden">
          <div class="message-chat-actions">
            <i class="fa-solid fa-paperclip"></i>
            <textarea rows="1" class="form-control message-chat-msg-input" placeholder="Type a message here"></textarea>
            <i class="fa-solid fa-reply"></i>
          </div>
          <div class="visually-hidden attachmentSent">
          </div>
          <div class="message-chat-attachments visually-hidden normalConvo">
            <div class="message-chat-attachment"></div>
            <div class="message-chat-attachment"></div>
            <div class="message-chat-attachment"></div>
            <div class="message-chat-attachment"></div>
            <div class="message-chat-attachment"></div>
            <div class="message-chat-attachment"></div>
            <div class="message-chat-attachment"></div>
            <div class="message-chat-attachment"></div>
            <div class="message-chat-attachment"></div>
          </div>
        </div>

        <div class="message-chat-area visually-hidden attachmentSent">
          <div class="message-chat-sent">
            <div></div>
          </div>
          <div class="message-chat-sent">
            <div></div>
          </div>
        </div>
        <div class="message-chat-area visually-hidden normalConvo">
          <div class="message-chat-received">consectetur adipiscing elit, sed do eiusmod tempor incididunt ut</div>
          <div class="message-chat-sent">labore et dolore magna aliqua. </div>
          <div class="message-chat-received">Ut enim ad minim veniam, quis nostrud exercitation ullamco</div>
          <div class="message-chat-sent">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla </div>
        </div>
      </div>

      <div class="container-messages-conversations">
        <div class="message-conversation-search-area">
          <input type="search" class="form-control form-search message-conversation-search" placeholder="Search">
          <!-- TODO -->
          <!-- 1. Implement real-time search results. -->
          <div class="message-conversation-search-results"></div>
        </div>
        <div class="messages-conversation-area">
          <div class="messages-conversation">
            <div class="message-conversation-user"></div>

            <div class="message-conversation-formal">
              <div class="message-conversation-user-info">
                <div class="message-conversation-username">User Name</div>
                <div class="message-conversation-user-status online"></div>
              </div>
              <div class="message-conversation-msg-info">
                <div class="message-conversation-sneakpeek">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, nostrum.
                </div>
                <div class="message-conversation-timestamp">3 Nov</div>
              </div>
            </div>
          </div>
          <div class="messages-conversation">
            <div class="message-conversation-user"></div>

            <div class="message-conversation-formal">
              <div class="message-conversation-user-info">
                <div class="message-conversation-username">User Name</div>
                <div class="message-conversation-user-status online"></div>
              </div>
              <div class="message-conversation-msg-info">
                <div class="message-conversation-sneakpeek">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, nostrum.
                </div>
                <div class="message-conversation-timestamp">2 Nov</div>
              </div>
            </div>
          </div>
          <div class="messages-conversation">
            <div class="message-conversation-user"></div>

            <div class="message-conversation-formal">
              <div class="message-conversation-user-info">
                <div class="message-conversation-username">User Name</div>
                <div class="message-conversation-user-status"></div>
              </div>
              <div class="message-conversation-msg-info">
                <div class="message-conversation-sneakpeek">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, nostrum.
                </div>
                <div class="message-conversation-timestamp">25 Oct</div>
              </div>
            </div>
          </div>
          <div class="messages-conversation">
            <div class="message-conversation-user"></div>

            <div class="message-conversation-formal">
              <div class="message-conversation-user-info">
                <div class="message-conversation-username">User Name</div>
                <div class="message-conversation-user-status"></div>
              </div>
              <div class="message-conversation-msg-info">
                <div class="message-conversation-sneakpeek">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, nostrum.
                </div>
                <div class="message-conversation-timestamp">10 Oct</div>
              </div>
            </div>
          </div>
          <div class="messages-conversation">
            <div class="message-conversation-user"></div>

            <div class="message-conversation-formal">
              <div class="message-conversation-user-info">
                <div class="message-conversation-username">User Name</div>
                <div class="message-conversation-user-status online"></div>
              </div>
              <div class="message-conversation-msg-info">
                <div class="message-conversation-sneakpeek">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, nostrum.
                </div>
                <div class="message-conversation-timestamp">Dec 2020</div>
              </div>
            </div>
          </div>
          <div class="messages-conversation">
            <div class="message-conversation-user"></div>

            <div class="message-conversation-formal">
              <div class="message-conversation-user-info">
                <div class="message-conversation-username">User Name</div>
                <div class="message-conversation-user-status"></div>
              </div>
              <div class="message-conversation-msg-info">
                <div class="message-conversation-sneakpeek">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, nostrum.
                </div>
                <div class="message-conversation-timestamp">10 Oct</div>
              </div>
            </div>
          </div>
          <div class="messages-conversation">
            <div class="message-conversation-user"></div>

            <div class="message-conversation-formal">
              <div class="message-conversation-user-info">
                <div class="message-conversation-username">User Name</div>
                <div class="message-conversation-user-status"></div>
              </div>
              <div class="message-conversation-msg-info">
                <div class="message-conversation-sneakpeek">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, nostrum.
                </div>
                <div class="message-conversation-timestamp">21 Dec 2020</div>
              </div>
            </div>
          </div>
          <div class="messages-conversation">
            <div class="message-conversation-user"></div>

            <div class="message-conversation-formal">
              <div class="message-conversation-user-info">
                <div class="message-conversation-username">User Name</div>
                <div class="message-conversation-user-status online"></div>
              </div>
              <div class="message-conversation-msg-info">
                <div class="message-conversation-sneakpeek">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, nostrum.
                </div>
                <div class="message-conversation-timestamp">3 Nov</div>
              </div>
            </div>
          </div>
          <div class="messages-conversation">
            <div class="message-conversation-user"></div>

            <div class="message-conversation-formal">
              <div class="message-conversation-user-info">
                <div class="message-conversation-username">User Name</div>
                <div class="message-conversation-user-status online"></div>
              </div>
              <div class="message-conversation-msg-info">
                <div class="message-conversation-sneakpeek">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, nostrum.
                </div>
                <div class="message-conversation-timestamp">3 Nov</div>
              </div>
            </div>
          </div>
          <div class="messages-conversation">
            <div class="message-conversation-user"></div>

            <div class="message-conversation-formal">
              <div class="message-conversation-user-info">
                <div class="message-conversation-username">User Name</div>
                <div class="message-conversation-user-status online"></div>
              </div>
              <div class="message-conversation-msg-info">
                <div class="message-conversation-sneakpeek">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate, nostrum.
                </div>
                <div class="message-conversation-timestamp">3 Nov</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="copyright mx-auto">
    <a href="/src/common/about-us.html">about tindahan.ph</a>
    <div class="text-secondary">&copy 2021 tindahan.ph. All Rights Reserved.</div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>