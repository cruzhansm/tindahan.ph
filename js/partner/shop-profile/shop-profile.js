import {
  fetchStoreDetails,
  retrieveStoreProducts,
} from '../db-methods/retrieve.js';

import { Pagination } from '../../common/pagination.js';
import { getCurrentUser } from '../../common/products/db-methods/retrieve.js';

export var STORE = new Object();

window.onload = async () => {
  const store = JSON.parse(await fetchStoreDetails());
  const user = JSON.parse(await getCurrentUser());

  STORE = store;

  console.log(store);

  setVisibleEditButton(user);
  appendShopDetails(store);
  const products = JSON.parse(
    await retrieveStoreProducts(parseInt(store.store_id))
  );

  console.log(products);

  appendShopProducts(products);
};

function appendShopDetails(store) {
  const shopName = document.querySelector('#shopName');
  const shopImg = document.querySelector('#shopImg');
  const shopDesc = document.querySelector('#shopDesc');
  const shopAddress = document.querySelector('#shopAddress');
  const shopContact = document.querySelector('#shopContact');

  shopName.innerText = store.store_name;
  shopImg.setAttribute('src', store.store_img);
  shopDesc.innerText = store.store_description;
  shopAddress.innerText =
    store.store_address != ', ' ? store.store_address : 'Not yet set';
  shopContact.innerText =
    store.store_contact != null ? `+63 ${store.store_contact}` : 'Not yet set';
}

export function initializeModalData(store) {
  const form = document.querySelector('form');
  const address = store.store_address.split(', ');

  const actualData = [
    store.store_img,
    store.store_name,
    store.store_description,
    address[1],
    address[0],
    store.store_contact,
  ];

  Array.from(form.elements).forEach((elem, index) => {
    if (elem.localName.localeCompare('button') != 0 && index != 0) {
      elem.value = actualData[index];
    }

    if (index == 0) {
      const target = document.querySelector('#previewImg');

      target.setAttribute('src', store.store_img);
    }
  });
}

function appendShopProducts(products) {
  const pagination = new Pagination(
    'paginationContainer',
    products.length / 12,
    products.length > 0 ? true : false
  );

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

  let limit = 3;
  let idx = 0;

  for (let currentPage = 0; currentPage < pagination.pageTotal; currentPage++) {
    let target = document.querySelector(`#page${currentPage + 1}`);

    for (let num = 1; num <= limit && idx < products.length; num++) {
      let product = products[idx++];

      let productContainer = document.createElement('div');
      productContainer.classList.add('product-feed-block');

      productContainer.innerHTML = `
        <a href="/tindahan.ph/src/common/product.php?id=${product.product_id}">
          <img src='${product.product_img}' class="product-feed-img">
            <div class="product-feed-info">
              <div>${product.product_name}</div>
              <div class="product-feed-price">P${product.product_price}</div>
          </div>
        </a>
      `;

      target.append(productContainer);
    }
  }
}

function setVisibleEditButton(user) {
  const edit = document.querySelector('#edit');
  const link = document.querySelector('#storeo');

  if (user == parseInt(STORE.store_owner)) {
    edit.classList.remove('visually-hidden');
  } else {
    storeo.classList.remove('active');
    storeo.setAttribute(
      'href',
      '/tindahan.ph/src/partner/partner-shop-profile.php'
    );
  }
}
