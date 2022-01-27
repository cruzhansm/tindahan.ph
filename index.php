<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['suspended'] == 'true') {
  header('Location: /tindahan.ph/src/common/login.php?mode=login');
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

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://kit.fontawesome.com/056f419e6a.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="css/base/base.css">
  <link rel="stylesheet" href="css/components/components.css">
  <link rel="stylesheet" href="css/utilities/utilities.css">
  <link rel="stylesheet" href="css/common/common.css">
  <link rel="stylesheet" href="css/common/home/home.css">

  <script type="module" src="js/common/search.js"></script>
  <script src="js/common/products.js"></script>
  <script src="js/common/messaging.js"></script>
  <script src="js/common/auth/logout.js"></script>
  <script type="module" src="js/index.js"></script>
  <script type="module" src="js/common/settings/settings.js"></script>
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
          <img src="assets/images/tph-logo-512px.png" class="sidenav-header-img">
          <div class="sidenav-header-text">
            <div class="fw-bolder">tindahan.ph</div>
            <?php
            if (strcmp($_SESSION['role'], 'user') != 0) {
              echo '<div>' . strtoupper($_SESSION['role']) . '</div>';
            }
            ?>
          </div>
        </div>
        <div class="sidenav-links">
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
            <i class="fa-solid fa-gear" onclick="showSettings(verifySettings)"></i>
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

        <div class="container-carousel">
          <div class="container-home-carousel">
            <i class="carousel-control-prev fa-solid fa-chevron-left" data-bs-target="#homeCarousel" data-bs-slide="prev"></i>
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
            <i class="carousel-control-next fa-solid fa-chevron-right" type="button" data-bs-target="#homeCarousel" data-bs-slide="next"></i>
          </div>
        </div>

        <div class="product-title">Daily Discover</div>

        <div class="product-container">
          <div id="paginationPages" class="product-page-review-list"></div>
          <nav id="paginationContainer" class="pagination-container"></nav>
        </div>
      </div>
    </div>
  </div>


  <!-- DISCARDED MESSAGING -->
  <!-- <div class="container-messages visually-hidden">
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
          <!-- <div class="message-conversation-search-results"></div>
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
  </div> -->

  <div class="copyright mx-auto">
    <a href="src/common/about-us.html">about tindahan.ph</a>
    <div class="text-secondary">&copy 2021 tindahan.ph. All Rights Reserved.</div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>