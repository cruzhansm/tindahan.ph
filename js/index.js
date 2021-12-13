import { navigateToHome } from '/tindahan.ph/js/common/navigation/nav.js';
import { fetchUserDetails } from '/tindahan.ph/js/common/db-methods/retrieve.js';

export var USER_DETAILS = new Object();

window.onload = async function () {
  const view = new URLSearchParams(window.location.search);

  navigateToHome().then((resolve) => {
    const utype = view.get('u');

    if (!view.has('u')) {
      window.location.href = `${window.location.href}?u=${resolve}`;
    }

    if (utype !== 'admin') {
      const navbar = document.querySelector('.sidenav-links');

      navbar.innerHTML =
        utype == 'user' ? createUserNavbar() : createPartnerNavbar();

      // fetchMultipleProducts();
      // attachMessagingEventListener();
    }
  });

  fetchUserDetails().then((data) => {
    USER_DETAILS = data;
  })
};

function createUserNavbar() {
  return `<a href="#" class="sidenav-link active">
            <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
            <div class="sidenav-link-text">Home</div>
          </a>
          <a href="src/common/categories.php" class="sidenav-link">
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
          <a href="src/user/user-register-partner.php" class="sidenav-link">
            <i class="fa-solid fa-handshake sidenav-link-icon"></i>
            <div class="sidenav-link-text">Be a Partner</div>
          </a>`;
}

function createPartnerNavbar() {
  return `<a href="/tindahan.ph/index.php" class="sidenav-link active">
            <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
            <div class="sidenav-link-text">Home</div>
          </a>
          <a href="src/common/categories.php" class="sidenav-link">
            <i class="fa-solid fa-cubes sidenav-link-icon"></i>
            <div class="sidenav-link-text">Categories</div>
          </a>
          <a
            href="src/partner/partner-shop-profile.php"
            class="sidenav-link"
          >
            <i class="fa-solid fa-shop sidenav-link-icon"></i>
            <div class="sidenav-link-text">Shop Profile</div>
          </a>
          <a href="src/partner/partner-add-listing.php" class="sidenav-link">
            <i class="fa-solid fa-circle-plus sidenav-link-icon"></i>
            <div class="sidenav-link-text">Add Listing</div>
          </a>
          <a href="src/partner/partner-orders.html" class="sidenav-link">
            <i class="fa-solid fa-receipt sidenav-link-icon"></i>
            <div class="sidenav-link-text">Orders</div>
          </a>
          <a href="src/common/help-center.html" class="sidenav-link">
            <i class="fa-solid fa-headset sidenav-link-icon"></i>
            <div class="sidenav-link-text">Help Center</div>
          </a>`;
}