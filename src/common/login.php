<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>tindahan.ph — Log in</title>

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
    <link rel="stylesheet" href="../../css/common/common.css" />

    <script type="module" src="../../js/common/auth/login.js"></script>
    <script type="module" src="../../js/common/auth/signup.js"></script>
  </head>

  <body class="bg-primary">
    <!-- LOGIN FORM -->
    <div class="login-header">
      <img
        src="../../assets/images/tph-logo-512px.png"
        class="login-header-img"
        alt="tindahan.ph"
      />
      <div class="login-header-text fw-bolder">tindahan.ph</div>
    </div>
    <div class="body">
      <img
        src="../../assets/images/login-signup.svg"
        class="body-banner"
        alt="Login/Signup"
      />

      <form
        onsubmit="attemptLogin(event)"
        class="body-login rounded visually-hidden"
        id="login-box"
      >
        <div class="body-login-title">log in</div>
        <div class="for-validation">
          <input
            type="email"
            placeholder="email"
            class="form-control border-input"
            required
          />
        </div>
        <div class="for-validation">
          <input
            type="password"
            placeholder="password"
            class="form-control form-password border-input"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary border-content">
          log in
        </button>
        <div class="body-login-signup-link">
          New here?
          <a href="login.php?mode=signup" id="switch-login">Sign up</a>
        </div>
      </form>

      <!-- SIGNUP FORM -->
      <form
        onsubmit="attemptSignup(event)"
        class="body-signup rounded visually-hidden"
        id="signup-box"
      >
        <div class="body-signup-title">sign up</div>
        <div class="for-validation">
          <input
            type="email"
            placeholder="email"
            class="form-control border-input"
            required
          />
        </div>
        <div class="for-validation">
          <input
            type="text"
            id="fname"
            placeholder="first name"
            class="form-control border-input"
            required
          />
        </div>
        <div class="for-validation">
          <input
            type="text"
            id="lname"
            placeholder="last name"
            class="form-control border-input"
            required
          />
        </div>
        <div class="for-validation">
          <input
            type="password"
            placeholder="password"
            id="password"
            class="form-control form-password border-input password"
            required
          />
        </div>
        <div class='for-validation'>
          <input
            type="password"
            placeholder="confirm password"
            id="cpassword"
            class="form-control form-password border-input password"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary border-content">
          sign up
        </button>
        <div class="body-signup-terms">
          By signing up, you agree to tindahan.ph's<br />
          Terms of Service and Privacy Policy
        </div>
        <div class="body-signup-login-link">
          Have an account?
          <a href="login.php?mode=login" id="switch-signup">Log in</a>
        </div>
      </form>
    </div>

    <div class="copyright mx-auto">
      <a href="../../src/common/about-us.html" class="text-highlight"
        >about tindahan.ph</a
      >
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
