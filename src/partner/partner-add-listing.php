<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Listing</title>

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

    <script type="module" src="/tindahan.ph/js/common/search.js"></script>
    <script src="../../js/common/auth/logout.js"></script>
    <script
      type="module"
      src="../../js/partner/listings/add-listing.js"
    ></script>
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
            <a
              href="../../src/partner/partner-shop-profile.php"
              class="sidenav-link"
            >
              <i class="fa-solid fa-shop sidenav-link-icon"></i>
              <div class="sidenav-link-text">Shop Profile</div>
            </a>
            <a href="#" class="sidenav-link active">
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
            <div class="text-highlight fw-bold">Add Listing</div>
            <div class="header-icons">
              <i class="fa-solid fa-gear"></i>
              <div onclick="displayUserActions()">
              <img src="<?php echo $_SESSION['image']; ?>" class="user-image-icon" />
              <div class="user-image-actions visually-hidden">
                <div class="user-image-action no-hover">
                  <i class="fa-solid fa-user"></i>
                  <div><?php echo $_SESSION['fname']; ?></div>
                </div>
                <div class="user-image-action">
                  <i class="fa-solid fa-right-from-bracket"></i>
                  <span onclick="logout()">LOG OUT</span>
                </div>
              </div>
            </div>
            </div>
          </header>

          <div>
            <form class="container" onsubmit="attemptNewListing(event)">
              <div class="container-upload">
                <div class="img-custom-upload">
                  <img
                    alt="preview"
                    id="previewImg"
                    class="preview-image visually-hidden"
                  />
                </div>
                <label class="add-listing btn btn-primary custom-upload">
                  Upload
                  <input
                    id="listingImg"
                    type="file"
                    accept="image/*"
                    required
                    class="visually-hidden"
                  />
                </label>
              </div>
              <div class="row form-row">
                <!-- <div class="col-auto circle star-button">
                  <i class="fas fa-star"></i>
                </div> -->

                <div class="col-auto p-0">
                  <div class="long-col">
                    <div class="for-validation">
                      <input
                        id="listingName"
                        class="form-control long-input border-input"
                        type="text"
                        placeholder="Product Name"
                      />
                    </div>
                  </div>

                  <div class="long-col">
                    <div class="for-validation">
                      <input
                        class="form-control long-input border-input"
                        type="number"
                        id="listingPrice"
                        min="1"
                        max="99999"
                        minlength="1"
                        maxlength="5"
                        placeholder="Price"
                      />
                    </div>
                  </div>

                  <div class="long-col">
                    <div class="input-group long-input">
                      <select
                        id="listingCategory"
                        class="form-select border-input"
                      >
                        <option selected disabled>Category</option>
                        <option value="1">Food</option>
                        <option value="2">Cosmetics</option>
                        <option value="3">Furniture</option>
                        <option value="4">Women's</option>
                        <option value="5">Men's</option>
                        <option value="6">Accessories</option>
                        <option value="7">Electronics</option>
                        <option value="8">Kids</option>
                        <option value="9">Stationery</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-no-var">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      onclick="toggleVariations(event)"
                    />
                    <label class="no-var-cap">No variations</label>
                  </div>

                  <div class="col-var-inputs" id="variationList"></div>

                  <div id="addVariation" class="container-fluid col-add-var">
                    <div class="row" onclick="addNewVariation()">
                      <div class="col-auto circle add-button">
                        <i class="fas fa-plus"></i>
                      </div>

                      <div class="col-auto p-0">
                        <label class="add-var-cap">Add variation</label>
                      </div>
                    </div>
                  </div>

                  <div class="long-col">
                    <div class="for-validation register-form-textarea">
                      <textarea
                        id="shdesc"
                        cols="30"
                        rows="10"
                        class="form-control"
                        maxlength="500"
                      ></textarea>
                      <div class="character-count-area">
                        <span class="character-count" id="shdescMsgCount"
                          >0</span
                        >
                        <span> / </span>
                        <span class="charLimit">500</span>
                      </div>
                    </div>
                  </div>

                  <div class="long-col bottom">
                    <div class="for-validation">
                      <input
                        id="listingBrand"
                        class="form-control border-input"
                        type="text"
                        placeholder="Brand"
                        value="No brand"
                      />
                    </div>
                    <div class="for-validation">
                      <input
                        id="listingStock"
                        type="number"
                        class="form-control border-input"
                        min="1"
                        max="9999"
                        minlength="1"
                        maxlength="4"
                        placeholder="Stock"
                      />
                    </div>
                  </div>

                  <!-- <div class="ship-cap">
                    <label class="ship-color">Ships from:</label>
                  </div>

                  <div class="ship-div">
                    <div class="row">
                      <div class="col-auto p-0">
                        <select
                          class="form-select shipping-input-city border-input"
                        >
                          <option selected disabled>City</option>
                          <option>Cebu City</option>
                          <option>Lapu-Lapu City</option>
                          <option>Mandaue City</option>
                        </select>
                      </div>

                      <div class="col-auto p-0">
                        <input type="text" class="shipping-input-barangay form-control" placeholder="Barangay">
                      </div>
                    </div>
                  </div> -->
                </div>
              </div>

              <div class="row row-btns mx-auto">
                <!-- <div class="col-auto p-0">
                  <button type="button" class="drafts-button btn btn-tertiary">
                    DRAFTS
                  </button>
                </div> -->

                <button type="submit" class="publish-button btn btn-primary">
                  Send Listing Application
                </button>
              </div>
            </form>
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
