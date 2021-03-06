import { navigateToHome } from '/tindahan.ph/js/common/navigation/nav.js';
import { fetchMultipleProducts } from '/tindahan.ph/js/common/db-methods/retrieve.js';
import { Pagination } from '/tindahan.ph/js/common/pagination.js';


window.onload = async () => {
  const view = new URLSearchParams(window.location.search);

  navigateToHome().then(async (resolve) => {
    const utype = view.get('u');

    if (!view.has('u')) {
      window.location.href = `${window.location.href}?u=${resolve}`;
    }

    if (utype !== 'admin') {
      const navbar = document.querySelector('.sidenav-links');

      navbar.innerHTML =
        utype == 'user' ? createUserNavbar() : createPartnerNavbar();

      let products = JSON.parse(await fetchMultipleProducts());
      console.log(products);
      appendDiscoverProducts(products);
    }
  });
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
          <a href="src/user/user-cart.php" class="sidenav-link">
            <i class="fa-solid fa-cart-shopping sidenav-link-icon"></i>
            <div class="sidenav-link-text">Cart</div>
          </a>
          <a href="src/user/user-purchases.php" class="sidenav-link">
            <i class="fa-solid fa-bag-shopping sidenav-link-icon"></i>
            <div class="sidenav-link-text">My Purchases</div>
          </a>
          <a href="src/user/user-register-partner.php" class="sidenav-link">
            <i class="fa-solid fa-handshake sidenav-link-icon"></i>
            <div class="sidenav-link-text">Be a Partner</div>
          </a>`;

  //           <a href="src/common/help-center.html" class="sidenav-link">
  //   <i class="fa-solid fa-headset sidenav-link-icon"></i>
  //   <div class="sidenav-link-text">Help Center</div>
  // </a>
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
          <a href="src/partner/partner-orders.php" class="sidenav-link">
            <i class="fa-solid fa-receipt sidenav-link-icon"></i>
            <div class="sidenav-link-text">Orders</div>
          </a>`;
}

function appendDiscoverProducts(products) {
  const pagination = new Pagination(
    'paginationContainer',
    products.length / 12,
    products.length > 0 ? true : false
  );

  console.log(products.length);

  let limit = 12;
  let idx = 0;

  const paginationPages = Array.from(
    document.querySelectorAll('.pagination-page')
  );

  paginationPages.forEach((page) => {
    page.classList.add(
      'container-product-feed',
      'row',
      'row-cols-4',
      'row-cols-md-4',
      'g-4'
    );
  });

  for (let currentPage = 0; currentPage < pagination.pageTotal; currentPage++) {
    let target = document.querySelector(`#page${currentPage + 1}`);

    for (let num = 1; num <= limit && idx < products.length; num++) {
      let product = products[idx++];
      let productContainer = document.createElement('div');
      productContainer.classList.add('product-feed-block');

      productContainer.innerHTML = `<a href='/tindahan.ph/src/common/product.php?id=${product.product_id}' class="product-feed-block">
        <img src="${product.product_img}" class="product-feed-img" />
        <div class="product-feed-info">
          <div>${product.product_name}</div>
          <div class="product-feed-price">${product.product_price}</div>
        </div>
        <div class="product-feed-store">${product.product_store.store_name}</div>
      </a>`;

      target.append(productContainer);
    }
  }
}
