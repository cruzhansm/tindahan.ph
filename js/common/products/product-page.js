import { Pagination } from '../pagination.js';
import { getCurrentUser, getProductDetails } from './db-methods/retrieve.js';
import { addToCart } from './db-methods/insert.js';

var PRODUCT = new Object();

window.onload = async () => {
  const productID = new URLSearchParams(window.location.search);

  console.log(productID.get('id'));

  const product = JSON.parse(await getProductDetails(productID.get('id')));

  console.log(product);

  if (await product.error) {
    alert(`${product.error} \n${product.error_msg}`);
    window.location.href = '/tindahan.ph/src/common/404.html';
  } else {
    PRODUCT = product;

    // PAGINATION:: A class representing the pagination controller
    // WHEN: Create a new instance of a Pagination object when you have
    // a pagination in your page.
    // CONSTRUCTOR: String form of the pagination container ID | the number
    // of pages to be generated for pagination (num of items / max) |
    // visibility of pagination (true - visible; false - hidden)
    // REFER TO appendReviews() function below for implementation
    const pagination = new Pagination(
      'paginationContainer',
      product.product_reviews.length / 3,
      product.product_reviews.length > 0 ? true : false
    );
    appendProductDetails(product);
    initializeEditButton(product.store_owner);
    appendVariations(product.product_variations);
    updateAddToCart(
      product.product_variations.length > 0
        ? product.product_variations[0].quantity > 0
          ? true
          : false
        : true
    );
    attachQuantityChangeListeners();
    appendReviews(product.product_reviews);
  }
};

function appendProductDetails(product) {
  const productPageTitle = document.querySelector('#productPageTitle');
  const productImg = document.querySelector('#productImg');
  const productName = document.querySelector('#productName');
  const productPrice = document.querySelector('#productPrice');
  const productRating = document.querySelector('#productRating');
  const productRatingCount = document.querySelector('#productRatingCount');
  const productStore = document.querySelector('#productStore');
  const productCategories = document.querySelector('#productCategories');
  const productBrand = document.querySelector('#productBrand');
  const productQuantity = document.querySelector('#productQuantity');
  const productDesc = document.querySelector('#productDesc');

  productPageTitle.innerText = product.product_name;
  productImg.setAttribute('src', product.product_img);
  productName.innerText = product.product_name;
  productPrice.innerText = `P${product.product_price}`;
  productRating.innerText = product.product_rating;
  productRatingCount.innerText = product.review_count;
  productStore.setAttribute(
    'href',
    `/tindahan.ph/src/partner/partner-shop-profile.php?id=${product.product_store.store_id}`
  );
  productStore.innerText = product.product_store.store_name;
  productCategories.innerHTML += `<div>${product.product_categories
    .reduce((c, s) => [...c, s], [])
    .join(', ')}</div>`;
  productBrand.innerText = `Brand: ${product.product_brand}`;
  productQuantity.innerText = `${product.product_quantity} pieces left`;
  productDesc.innerText = product.product_desc;
}

async function initializeEditButton(storeOwner) {
  const currentUser = JSON.parse(await getCurrentUser());
  const buttons = document.querySelectorAll('.edit');

  if (parseInt(currentUser) == parseInt(storeOwner)) {
    buttons.forEach((button) => button.classList.remove('visually-hidden'));
  }
}

function appendVariations(variations) {
  const select = document.querySelector('#productVariation');

  if (variations.lengths != 0) {
    variations.forEach((variation) => {
      select.innerHTML += `
        <option value="${variation.variation_id}">${variation.variation}</option>;
      `;
    });
    attachVariationChangeListeners(select, variations);
  }
}

function attachVariationChangeListeners(select, variations) {
  const price = document.querySelector('#productPrice');
  const quantity = document.querySelector('#productQuantity');

  select.addEventListener('change', () => {
    let updated = variations.find((v) => v.variation_id == select.value);

    if (updated == null) {
      price.innerText = `P${PRODUCT.product_price}`;
      quantity.innerText = `${PRODUCT.product_quantity} pieces left.`;
    } else {
      price.innerText = `P${updated.price}`;
      quantity.innerText = `${updated.quantity} pieces left.`;
      updateAddToCart(updated.quantity > 0 ? true : false);
    }
  });
}

function attachQuantityChangeListeners() {
  const minus = document.querySelector('#minus');
  const plus = document.querySelector('#plus');
  const quantityArea = document
    .querySelector('#inStock')
    .querySelector('#buyCount');
  let limit = parseInt(
    document.querySelector('#inStock').querySelector('#productQuantity')
      .innerText
  );
  let actualQuantity = parseInt(quantityArea.innerText);

  minus.addEventListener('click', () => {
    limit = parseInt(
      document.querySelector('#inStock').querySelector('#productQuantity')
        .innerText
    );
    actualQuantity = parseInt(quantityArea.innerText);
    quantityArea.innerText =
      actualQuantity > 1 ? --actualQuantity : actualQuantity;
  });

  plus.addEventListener('click', () => {
    limit = parseInt(
      document.querySelector('#inStock').querySelector('#productQuantity')
        .innerText
    );
    actualQuantity = parseInt(quantityArea.innerText);
    quantityArea.innerText =
      actualQuantity < limit ? ++actualQuantity : actualQuantity;
  });
}

function updateAddToCart(state) {
  const inStock = document.querySelector('#inStock');
  const outStock = document.querySelector('#outStock');
  const quantityArea = document
    .querySelector('#inStock')
    .querySelector('#buyCount');

  if (state == false) {
    if (!inStock.classList.contains('visually-hidden')) {
      inStock.classList.add('visually-hidden');
    }
    outStock.classList.remove('visually-hidden');
  } else {
    if (!outStock.classList.contains('visually-hidden')) {
      outStock.classList.add('visually-hidden');
    }
    inStock.classList.remove('visually-hidden');
  }

  quantityArea.innerText = 1;
}

// This function is generally how you would use pagination.
// When creating a new instance of a pagination, it will automatically
// create and append (num of items / max items per page) number of divs
// to the pagination pages container. Each div has an id of #page{num}
// starting at page#1. You have to manually append the items you want to
// append (such as products, reviews, etc) per pagination page, and following
// the max number of items per page. Example of which is below:
function appendReviews(reviews) {
  const pages = Math.ceil(reviews.length / 3);
  const reviewContainer = document.querySelector('.product-page-reviews');
  const noReviews = document.querySelector('#noReviews');
  const reviewList = document.querySelector('.product-page-review-list');
  const pagination = document.querySelector('.pagination-container');

  if (reviews.length == 0) {
    reviewContainer.classList.add('unpopulated');
    noReviews.classList.remove('visually-hidden');
    reviewList.classList.add('visually-hidden');
    pagination.classList.add('visually-hidden');
  } else {
    reviewContainer.classList.add('populated');

    let limit = 3;
    let idx = 0;

    for (let currentPage = 0; currentPage < pages; currentPage++) {
      let target = document.querySelector(`#page${currentPage + 1}`);

      for (let num = 1; num <= limit && idx < reviews.length; num++) {
        let productReview = document.createElement('div');
        let review = reviews[idx++];

        productReview.classList.add('product-page-review');

        productReview.innerHTML = `
            <div class="product-page-review-header">
              <div id="user${
                review.user_id
              }" class="product-page-review-reviewer">${review.user_name}</div>
              <div class="product-page-review-date">${review.timestamp
                .split(' ')[0]
                .split('-')
                .reverse()
                .join('/')}</div>
            </div>
            <div class="product-page-review-rating">
              <i class="fa-solid fa-star"></i>
              ${parseInt(review.rating)}
            </div>
            <div class="product-page-review-details">${review.review_msg}</div>
            <div
              class="product-page-review-attachments ${
                review.images != null
                  ? review.images.length > 0
                    ? ''
                    : 'visually-hidden'
                  : ''
              }">${
          review.images != null ? appendReviewImages(review.images) : ''
        }</div>`;
        target.append(productReview);
      }
    }
  }
}

function appendReviewImages(images) {
  let list = new String();

  images.forEach((image) => {
    list += `<img src="${image}" class="product-page-review-attachment" />`;
  });

  return list;
}

window.attemptAddToCart = function attemptAddToCart() {
  const variation = parseInt(document.querySelector('#productVariation').value);

  const cartItem = {
    productID: PRODUCT.product_id,
    storeID: PRODUCT.product_store.store_id,
    variationID: isNaN(variation) ? null : variation,
    quantity: parseInt(
      document.querySelector('#inStock').querySelector('#buyCount').innerText
    ),
  };

  addToCart(cartItem);
};

window.redirectToEdit = function redirectToEdit() {
  window.location.href = `/tindahan.ph/src/partner/edit-listing.php?id=${PRODUCT.product_id}`;
};
