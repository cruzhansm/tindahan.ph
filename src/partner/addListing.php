<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Listing</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://kit.fontawesome.com/056f419e6a.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../../css/base/base.css">
  <link rel="stylesheet" href="../../css/components/components.css">
  <link rel="stylesheet" href="../../css/utilities/utilities.css">

  <style>
    div {
      border: 1px solid white
    }
  </style>
</head>

<script>
  function noSubmit(e) {

    e.preventDefault();
  }
</script>

<body class="bg-primary" style="min-height: 1080px; min-width: 1920px;">
  <div class="sidenav">
    <div class="sidenav-header">
      <div class="sidenav-header-img"></div>
      <div class="sidenav-header-text">tindahan.ph</div>
    </div>
    <div class="sidenav-links">
      <div class="sidenav-link active">
        <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
        <div class="sidenav-link-text">Home</div>
      </div>
      <div class="sidenav-link">
        <i class="fa-solid fa-cubes sidenav-link-icon"></i>
        <div class="sidenav-link-text">Categories</div>
      </div>
      <div class="sidenav-link">
        <i class="fa-solid fa-cart-shopping sidenav-link-icon"></i>
        <div class="sidenav-link-text">Cart</div>
      </div>
      <div class="sidenav-link">
        <i class="fa-solid fa-bag-shopping sidenav-link-icon"></i>
        <div class="sidenav-link-text">My Purchases</div>
      </div>
      <div class="sidenav-link">
        <i class="fa-solid fa-headset sidenav-link-icon"></i>
        <div class="sidenav-link-text">Support</div>
      </div>
    </div>
  </div>

  <div class="container container-display">
    <header class="header">
      <div class="header-text">Add Listing</div>
      <div class="header-icons">
        <i class="fa-solid fa-inbox"></i>
        <i class="fa-solid fa-gear"></i>
        <div class="user-image-icon"></div>
      </div>
    </header>

    <div class="container-home-slideshow"></div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>