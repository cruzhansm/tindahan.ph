<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Listing</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://kit.fontawesome.com/056f419e6a.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/base/base.css" />
  <link rel="stylesheet" href="../../css/components/components.css" />
  <link rel="stylesheet" href="../../css/utilities/utilities.css" />
  <link rel="stylesheet" href="../../css/partner/partner.css" />

  <!-- <style>
    div {
      border: 1px solid white
    }
  </style> -->
  </head>

  <script>
    function noSubmit(e) {
      e.preventDefault();
    }
  </script>

  <body class="bg-primary">
    <div class="row m-0">
      <div class="col left">
        <div class="sidenav">
          <div class="sidenav-header">
            <div class="sidenav-header-img"></div>
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
        
        <div class="sidenav-links">
          <a href="../../index.php" class="sidenav-link">
            <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
            <div class="sidenav-link-text">Home</div>
          </a>
          <a href="../../src/common/categories.html" class="sidenav-link">
            <i class="fa-solid fa-cubes sidenav-link-icon"></i>
            <div class="sidenav-link-text">Categories</div>
          </a>
          <a href="../../src/partner/partner-shop-profile.php" class="sidenav-link">
            <i class="fa-solid fa-shop sidenav-link-icon"></i>
            <div class="sidenav-link-text">Shop Profile</div>
          </a>
          <a href="#" class="sidenav-link active">
            <i class="fa-solid fa-circle-plus sidenav-link-icon"></i>
            <div class="sidenav-link-text">Add Listing</div>
          </a>
          <a href="../../src/partner/partner-orders.html" class="sidenav-link">
            <i class="fa-solid fa-receipt sidenav-link-icon"></i>
            <div class="sidenav-link-text">Orders</div>
          </a>
          <a href="../../src/common/help-center.html" class="sidenav-link">
            <i class="fa-solid fa-headset sidenav-link-icon"></i>
            <div class="sidenav-link-text">Help Center</div>
          </a>
        </div>
      </div>
      <div class="col right">
        <div class="container-display">
          <header class="header">
            <div class="text-highlight fw-bold">Edit Listing</div>
            <div class="header-icons">
              <i class="fa-solid fa-gear"></i>
              <div class="user-image-icon"></div>
            </div>
          </header>

      <div class="sidenav-links">
        <a href="../../index.php" class="sidenav-link">
          <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
          <div class="sidenav-link-text">Home</div>
        </a>
        <a href="../../src/common/categories.html" class="sidenav-link">
          <i class="fa-solid fa-cubes sidenav-link-icon"></i>
          <div class="sidenav-link-text">Categories</div>
        </a>
        <a href="../../src/partner/partner-shop-profile.html" class="sidenav-link">
          <i class="fa-solid fa-shop sidenav-link-icon"></i>
          <div class="sidenav-link-text">Shop Profile</div>
        </a>
        <a href="#" class="sidenav-link active">
          <i class="fa-solid fa-circle-plus sidenav-link-icon"></i>
          <div class="sidenav-link-text">Add Listing</div>
        </a>
        <a href="../../src/partner/partner-orders.html" class="sidenav-link">
          <i class="fa-solid fa-receipt sidenav-link-icon"></i>
          <div class="sidenav-link-text">Orders</div>
        </a>
        <a href="../../src/common/help-center.html" class="sidenav-link">
          <i class="fa-solid fa-headset sidenav-link-icon"></i>
          <div class="sidenav-link-text">Help Center</div>
        </a>
      </div>
    </div>
  </div>
  <div class="col right">
    <div class="container-display">
      <header class="header">
        <div class="text-highlight fw-bold">Edit Listing</div>
        <div class="header-icons">
          
          <i class="fa-solid fa-gear"></i>
          <div class="user-image-icon"></div>
        </div>
      </header>

      <div>
        <div class="container-upload"></div>
        <div class="upload-caption">You can add up to 10 photos</div>
        <form class="container" action="">
          <div class="row form-row">
            <div class="col-auto circle star-button">
              <i class="fas fa-star"></i>
            </div>

            <div class="col-auto p-0">
              <div class="long-col">
                <input class="form-control long-input border-input" type="text" value="Picture Frame"
                  placeholder="Product Name" />
              </div>

              <div class="long-col">
                <input class="form-control long-input border-input" type="text" value="79.99" placeholder="Price" />
              </div>

              <div class="long-col">
                <div class="input-group long-input">
                  <select class="form-select border-input">
                    <option disabled>Category</option>
                    <option>Food</option>
                    <option>Cosmetics</option>
                    <option>Furniture</option>
                    <option>Women's</option>
                    <option>Men's</option>
                    <option>Jewelry</option>
                    <option>Electronics</option>
                    <option>Kids</option>
                    <option selected>Stationery</option>
                  </select>
                </div>
              </div>

              <div class="col-no-var">
                <input class="form-check-input" type="checkbox" />
                <label class="no-var-cap">No variations</label>
              </div>

              <div class="col-var-inputs">
                <div class="row">
                  <div class="col-auto p-0">
                    <input class="form-control variation-input border-input" type="text" value="Basket Weave frame"
                      placeholder="Variation" />
                  </div>

                  <div class="col-auto p-0">
                    <input class="form-control stock-input border-input" type="text" value="5" placeholder="Stock" />
                  </div>
                </div>
              </div>

              <div class="col-var-inputs">
                <div class="row">
                  <div class="col-auto p-0">
                    <input class="form-control variation-input border-input" type="text" value="Pure White frame"
                      placeholder="Variation" />
                  </div>

                  <div class="col-auto p-0">
                    <input class="form-control stock-input border-input" type="text" value="5" placeholder="Stock" />
                  </div>
                </div>
              </div>

              <div class="col-var-inputs">
                <div class="row">
                  <div class="col-auto p-0">
                    <input class="form-control variation-input border-input" type="text" value="Pure Black frame"
                      placeholder="Variation" />
                  </div>

                  <div class="col-auto p-0">
                    <input class="form-control stock-input border-input" type="text" value="5" placeholder="Stock" />
                  </div>
                </div>
              </div>

              <div class="container-fluid col-add-var">
                <div class="row">
                  <div class="col-auto circle add-button">
                    <i class="fas fa-plus"></i>
                  </div>

                  <div class="col-auto p-0">
                    <label class="add-var-cap">Add variation</label>
                  </div>
                </div>
              </div>

              <div class="long-col">
                <textarea class="form-control descript-input" placeholder="Description. Max 500 words">
Frame to put pictures on.</textarea>
              </div>

              <div class="long-col">
                <input class="form-control long-input border-input" type="text" value="None" placeholder="Brand" />
              </div>
            </div>
          </div>

          <div class="row row-btns">
            <div class="col-auto p-0">
              <button type="button" class="drafts-button btn btn-tertiary">
                DRAFTS
              </button>
            </div>

            <div class="col-auto p-0">
              <button type="button" class="publish-button btn btn-primary">
                PUBLISH
              </button>
            </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>