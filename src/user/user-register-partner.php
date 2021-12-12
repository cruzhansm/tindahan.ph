<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>tindahan.ph - Be a Partner</title>

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
    <script type="module" src="../../js/user/register-partner.js"></script>
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
              <input
                type="search"
                class="form-control form-search border-input visually-hidden"
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

        <div class="container-register register-prompt visually-hidden">
          <div class="register-hero">
            <div class="register-hero-header">
              <div class="register-hero-bold">start a tindahan with us</div>
              <img
                src="../../assets/images/user/be-a-partner.svg"
                class="register-hero-img"
              />
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
              <input
                id="storeName"
                type="text"
                class="form-control no-success"
                placeholder="shop name"
              />
            </div>
            <div class="register-form-categories">
              <label for="categ" class="form-control"
                >What do you mainly sell?</label
              >
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
                    <input
                      name="onlineSelling"
                      id="yesNewSell"
                      type="radio"
                      class="form-check-input"
                      value="no"
                      checked
                    />
                    <label for="yesNewSell" class="form-control">Yes</label>
                  </div>
                  <div class="input-group">
                    <input
                      name="onlineSelling"
                      id="noNewSell"
                      type="radio"
                      class="form-check-input"
                      value="yes"
                    />
                    <label for="noNewSell" class="form-control">No</label>
                  </div>
                </div>
              </div>
              <div class="register-form-platforms">
                <label for="platforms" class="form-control"
                  >If not, what are the other online selling platforms that you
                  use?</label
                >
                <div class="for-validation disabled">
                  <input
                    id="platforms"
                    type="text"
                    class="form-control no-success"
                    placeholder="online selling platforms"
                  />
                </div>
              </div>
            </div>

            <div class="register-form-input-desc">
              <label for="shdesc" class="form-control"
                >Short description of shop (Max of 200 characters)</label
              >
              <div class="for-validation" style="width: 100%">
                <div class="register-form-textarea">
                  <textarea
                    id="shdesc"
                    cols="30"
                    rows="10"
                    class="form-control no-success"
                    maxlength="200"
                  ></textarea>
                  <div class="character-count-area">
                    <span class="character-count" id="shdescMsgCount">0</span>
                    <span> / </span>
                    <span class="charLimit">200</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="register-form-upload">
              <label class="form-control"
                >Shop picture or logo (Max <span id="fileLimit">1</span>)</label
              >
              <div class="register-form-custom-upload">
                <img
                  alt="preview"
                  id="previewImg"
                  class="preview-image visually-hidden"
                />
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

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
