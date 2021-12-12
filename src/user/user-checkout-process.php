<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>tindahan.ph - Checkout</title>

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
    <link rel="stylesheet" href="../../css/partner/orders/orders.css" />
    <link rel="stylesheet" href="../../css/user/user.css" />

    <script src="../../js/common/auth/logout.js"></script>
    <script type="module" src="../../js/user/checkout-process.js"></script>
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
            </div>
          </div>
          <div class="sidenav-links">
            <a href="/tindahan/ph/index.php" class="sidenav-link">
              <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
              <div class="sidenav-link-text">Home</div>
            </a>
            <a href="../../src/common/categories.html" class="sidenav-link">
              <i class="fa-solid fa-cubes sidenav-link-icon"></i>
              <div class="sidenav-link-text">Categories</div>
            </a>
            <a href="../../src/user/user-cart.php" class="sidenav-link">
              <i class="fa-solid fa-cart-shopping sidenav-link-icon"></i>
              <div class="sidenav-link-text">Cart</div>
            </a>
            <a href="../../src/user/user-purchases.html" class="sidenav-link">
              <i class="fa-solid fa-bag-shopping sidenav-link-icon"></i>
              <div class="sidenav-link-text">My Purchases</div>
            </a>
            <a href="../../src/common/help-center.html" class="sidenav-link">
              <i class="fa-solid fa-headset sidenav-link-icon"></i>
              <div class="sidenav-link-text">Help Center</div>
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
          <header class="header">
            <div class="text-highlight fw-bold">Checkout</div>
            <div class="header-icons">
              <i class="fa-solid fa-inbox"></i>
              <i class="fa-solid fa-gear"></i>
              <div class="user-image-icon" onclick="displayUserActions()">
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

          <div class="container-checkout-progress mx-auto">
            <div class="checkout-progress">
              <div class="checkout-progress-step done">1</div>
              <div class="checkout-progress-process">Form</div>
            </div>
            <div class="checkout-progress-bar"></div>
            <div class="checkout-progress">
              <div class="checkout-progress-step">2</div>
              <div class="checkout-progress-process">Summary</div>
            </div>
            <div class="checkout-progress-bar"></div>
            <div class="checkout-progress">
              <div class="checkout-progress-step">3</div>
              <div class="checkout-progress-process">Payment</div>
            </div>
            <div class="checkout-progress-bar"></div>
            <div class="checkout-progress">
              <div class="checkout-progress-step">4</div>
              <div class="checkout-progress-process">Done</div>
            </div>
          </div>

          <div class="container-checkout-process mx-auto">
            <div class="container-checkout-process-title">information form</div>
            <form
              id="checkoutInfo"
              onsubmit="proceedToSummary(event)"
              class="checkout-process-form"
            >
              <div class="for-validation">
                <input
                  id="recipientFname"
                  type="text"
                  class="form-control no-success"
                />
              </div>
              <div class="for-validation">
                <input
                  id="recipientLname"
                  type="text"
                  class="form-control no-success"
                />
              </div>
              <div class="form-contact-number for-validation checkout">
                <input
                  id="recipientContact"
                  type="number"
                  maxlength="10"
                  minlength="10"
                  placeholder="contact number"
                  class="form-control no-success"
                />
                <span class="form-control-number prefix">+63</span>
              </div>
              <div class="for-validation">
                <input
                  id="recipientStreet"
                  type="text"
                  class="form-control no-success"
                  placeholder="floor/unit/room/street"
                />
              </div>
              <div class="inline-form">
                <select name="" id="recipientCity" class="form-select">
                  <option value="Bogo City">Bogo City</option>
                  <option value="Carcar City">Carcar City</option>
                  <option value="Cebu City">Cebu City</option>
                  <option value="Danao City">Danao City</option>
                  <option value="Lapu-Lapu CLapu-Lapu">City</option>
                  <option value="Mandaue City">Mandaue City</option>
                  <option value="Naga City">Naga City</option>
                  <option value="Talisay City">Talisay City</option>
                  <option value="Toledo City">Toledo City</option>
                </select>
                <div class="for-validation">
                  <input
                    id="recipientBrgy"
                    type="text"
                    class="form-control no-success"
                  />
                </div>
              </div>
              <div class="inline-form">
                <div class="for-validation">
                  <input
                    id="recipientLandmark"
                    type="text"
                    class="form-control no-success"
                    placeholder="landmark"
                  />
                </div>
                <div class="for-validation">
                  <input
                    id="recipientZipcode"
                    type="number"
                    maxlength="4"
                    minlength="4"
                    class="form-control no-success"
                    placeholder="zipcode"
                  />
                </div>
              </div>
              <div class="container-button-group information">
                <button
                  type="button"
                  class="btn btn-tertiary"
                  onclick="redirectPreviousURL()"
                >
                  Cancel
                </button>
                <button type="submit" class="btn btn-primary">Proceed</button>
              </div>
            </form>
          </div>

          <div class="container-checkout-process mx-auto visually-hidden">
            <div class="container-checkout-process-title">order summary</div>
            <div class="container-orders">
              <div class="orders-group"></div>
            </div>

            <div class="checkout-summary">
              <div class="checkout-voucher-area">
                <div class="for-validation">
                  <input
                    type="text"
                    id="orderVoucher"
                    class="form-control"
                    maxlength="15"
                    placeholder="voucher code"
                  />
                </div>
                <button
                  type="button"
                  class="btn btn-primary"
                  onclick="verifyValidVoucher()"
                >
                  Apply
                </button>
              </div>
              <div class="checkout-summary-detail">
                <div class="checkout-summary-calculations">
                  <div class="checkout-summary-costs">
                    <div>Subtotal</div>
                    <div>Shipping Fee</div>
                    <div>Voucher</div>
                  </div>
                  <div class="checkout-summary-prices">
                    <div id="orderSubtotal"></div>
                    <div id="orderDelivery"></div>
                    <div id="orderVoucherOff">-P0</div>
                  </div>
                </div>
                <div class="checkout-summary-total">
                  <div class="checkout-summary-costs">
                    <div>TOTAL</div>
                  </div>
                  <div class="checkout-summary-prices">
                    <div id="orderTotalPrice"></div>
                  </div>
                </div>
              </div>
              <div class="container-button-group">
                <button
                  class="btn btn-tertiary"
                  onclick="proceedToInformation()"
                >
                  Back
                </button>
                <button class="btn btn-primary" onclick="proceedToPayment()">
                  Proceed
                </button>
              </div>
            </div>
          </div>

          <div class="container-checkout-process mx-auto visually-hidden">
            <div class="container-checkout-process-title">payment method</div>
            <form
              id="payment"
              onsubmit="proceedToFinalStep(event)"
              class="checkout-process-form"
            >
              <div class="input-group">
                <input
                  id="cod"
                  name="paymentMethod"
                  type="radio"
                  class="form-check-input"
                  checked
                />
                <label for="cod" class="form-check-label"
                  >Cash on Delivery (COD)</label
                >
              </div>
              <div class="input-group">
                <input
                  id="cc"
                  name="paymentMethod"
                  type="radio"
                  class="form-check-input"
                />
                <label for="cc" class="form-check-label">Credit Card</label>
              </div>

              <div id="ccform" class="checkout-process-payment visually-hidden">
                <label for="email" class="form-control">email</label>
                <div class="for-validation">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    placeholder="enter email"
                  />
                </div>
                <label for="ccnum" class="form-control">card number</label>
                <div class="for-validation">
                  <input
                    id="ccnum"
                    type="number"
                    class="form-control"
                    minlength="16"
                    maxlength="16"
                    placeholder="enter card number"
                  />
                </div>

                <div class="checkout-process-payment-inline">
                  <div class="checkout-payment-expiry">
                    <label for="ccdetails" class="form-control"
                      >expiry date</label
                    >
                    <div class="checkout-payment-expiry-fields">
                      <div class="for-validation">
                        <input
                          type="number"
                          class="form-control"
                          id="ccdetails"
                          placeholder="MM"
                          min="1"
                          max="12"
                          minlength="1"
                          maxlength="2"
                        />
                      </div>
                      <div>/</div>
                      <div class="for-validation">
                        <input
                          type="number"
                          minlength="2"
                          maxlength="2"
                          class="form-control"
                          id="ccdetails"
                          placeholder="YY"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="for-validation checkout-payment-cvv">
                    <label for="cccvv" class="form-control">CVV</label>
                    <input
                      id="cccvv"
                      type="number"
                      min="000"
                      max="9999"
                      minlength="3"
                      maxlength="4"
                      class="form-control"
                    />
                  </div>
                </div>
              </div>

              <div class="container-button-group cod">
                <button
                  type="button"
                  class="btn btn-tertiary"
                  onclick="proceedBackToSummary()"
                >
                  Back
                </button>
                <button type="submit" class="btn btn-primary">Proceed</button>
              </div>
            </form>
          </div>

          <div class="container-checkout-process mx-auto visually-hidden">
            <div class="container-checkout-done">
              <img
                src="../../assets/images/user/order-successful.svg"
                alt="Order success!"
                class="checkout-process-done-img"
              />
              <div class="checkout-process-done-status">
                <div class="fs-24 text-highlight fw-bold">order successful</div>
                <div class="fs-18 text-secondary fw-bold">Your order is being processed.</div>
              </div>
              <div class="checkout-process-done-msg">
                head over to My Purchases for updates on your order
              </div>
            </div>
          </div>
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
