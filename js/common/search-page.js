import { fetchSearchResults } from "/tindahan.ph/js/common/db-methods/retrieve.js";
import { Pagination } from '/tindahan.ph/js/common/pagination.js';

window.onload = async () => {

  if (window.location.href.includes('search.php')) {
    const data = new URLSearchParams(window.location.search);
    let query = data.get('q');

    let products = JSON.parse(await fetchSearchResults(query));
    console.log(products);
    appendAllProducts(products);
  }
};

function appendAllProducts(products) {
  const pagination = new Pagination(
    'paginationContainer',
    products.length / 12,
    products.length > 0 ? true : false
  );

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

      productContainer.innerHTML =
      `<a href='/tindahan.ph/src/common/product.php?id=${product.product_id}' class="product-feed-block">
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