<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>tindahan.ph - Add Listing</title>

  <link rel="icon" type="image/png" href="../../assets/images/tph-logo-128px.png" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://kit.fontawesome.com/056f419e6a.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/base/base.css" />
  <link rel="stylesheet" href="../../css/components/components.css" />
  <link rel="stylesheet" href="../../css/utilities/utilities.css" />
  <link rel="stylesheet" href="../../css/common/common.css">
  <link rel="stylesheet" href="../../css/partner/partner.css" />

  <script type="module" src="../../js/common/input/form.js"></script>
  <script type="module" src="../../js/index.js"></script>
  <script type="module" src="../../js/partner/add-listing/add-listing.js"></script>

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
          <img src="../../assets/images/tph-logo-512px.png" class="sidenav-header-img">
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
          <div class="text-highlight fw-bold">Add Listing</div>
          <div class="header-icons">
            <i class="fa-solid fa-inbox"></i>
            <i class="fa-solid fa-gear"></i>
            <div class="user-image-icon"></div>
          </div>
        </header>

        <div>
          <form action="../../php/partner/add-listing-form.php" method="POST" enctype="multipart/form-data">

            <div class="container-upload">
              <div class="container-upload-custom">
                <img src="#" id="previewImg" class="preview-image visually-hidden">
              </div>
              <label class="btn btn-primary custom-upload">
                Upload
                <input name="img" id="upload_img" type="file" accept="image/*" />
              </label>
            </div>

            <div class="container">
              <div class="row form-row">
                <!-- <div class="col-auto circle star-button">
                  <i class="fas fa-star"></i>
                </div> -->

                <div class="col-auto p-0">
                  <div class="long-col">
                    <input class="form-control long-input border-input" name="name" type="text" placeholder="Product Name" required />
                  </div>

                  <div class="long-col">
                    <input class="form-control long-input border-input" name="price" type="text" placeholder="Price" required />
                  </div>

                  <div class="long-col">
                    <div class="input-group long-input">
                      <select name="category" class="form-select border-input">
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
                    <input class="form-check-input" type="checkbox" />
                    <label class="no-var-cap">No variations</label>
                  </div>

                  <div class="col-var-inputs">
                    <div class="row">
                      <div class="col-auto p-0">
                        <input class="form-control variation-input border-input" type="text" placeholder="Variation" />
                      </div>

                      <div class="col-auto p-0">
                        <input class="form-control stock-input border-input" type="text" placeholder="Stock" />
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
                    <textarea name="desc" class="form-control descript-input" placeholder="Description. Max 500 words" required></textarea>
                  </div>

                  <div class="long-col">
                    <input name="brand" class="form-control long-input border-input" type="text" placeholder="Brand" required />
                  </div>
                </div>
              </div>

              <div class="row row-btns">
                <div class="col-auto p-0">
                  <button type="submit" class="publish-button btn btn-primary" name="publish">
                    PUBLISH
                  </button>
                </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>