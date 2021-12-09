var PRODUCT_START_POS = 0;
var PRODUCT_INCREMENT = 12;
var PRODUCT_TOTAL_NUM = 60;
var PRODUCT_FETCH_MAX = false;
var PRODUCTS = [];

function fetchMultipleProducts() {
  $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/products/retrieve.php',
    data: {
      type: 'multiple-random',
      num: PRODUCT_TOTAL_NUM,
    },
    success: (result) => {
      result = JSON.parse(result);
      PRODUCTS = [...result];
      fetchProductsIncrementally();
    },
  });
}

function fetchProductsIncrementally() {
  const productFeed = document.querySelector('.container-product-feed');
  const productFetchBtn = document.createElement('button');
  let limit = PRODUCT_START_POS + PRODUCT_INCREMENT;

  try {
    productBtn = document.querySelector('.btn-tertiary');
  } catch {}

  productFetchBtn.classList.add('btn', 'btn-tertiary', 'mx-auto');
  productFetchBtn.setAttribute('onclick', 'fetchProductsIncrementally()');
  productFetchBtn.style.marginTop = '54px';
  productFetchBtn.innerText = 'VIEW MORE';

  if (productBtn !== null) {
    productBtn.remove();
  }

  for (
    let i = PRODUCT_START_POS;
    PRODUCT_START_POS < limit && PRODUCT_FETCH_MAX === false;
    i++
  ) {
    productFeed.innerHTML += `
      <div class="product-feed-block">
        <img src="${PRODUCTS[i].product_img}" class="product-feed-img" />
        <div class="product-feed-info">
          <div>${PRODUCTS[i].product_name}</div>
          <div class="product-feed-price">${PRODUCTS[i].product_price}</div>
        </div>
        <div class="product-feed-store">Partner Name</div>
      </div>
    `;
    PRODUCT_START_POS++;

    if (PRODUCT_START_POS === PRODUCT_TOTAL_NUM) {
      PRODUCT_FETCH_MAX = true;
    }
  }

  PRODUCT_FETCH_MAX === true
    ? productFeed.append(FeedProduct.maxMessage())
    : productFeed.append(productFetchBtn);
}
