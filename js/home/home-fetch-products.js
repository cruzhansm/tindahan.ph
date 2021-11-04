var PRODUCT_START_POS = 0;
var PRODUCT_INCREMENT = 12;
var PRODUCT_TOTAL_NUM = 60;
var PRODUCT_FETCH_MAX = false;

function fetchBatchProducts() {
  let productFeed = document.querySelector('.container-product-feed');
  let productFetchBtn = document.createElement('button');
  let limit = PRODUCT_START_POS + PRODUCT_INCREMENT;
  let productBtn;

  try {
    productBtn = document.querySelector('.btn-tertiary');
  }
  catch { }

  productFetchBtn.classList.add('btn', 'btn-tertiary', 'mx-auto');
  productFetchBtn.setAttribute('onclick', 'fetchBatchProducts()');
  productFetchBtn.style.marginTop = '54px';
  productFetchBtn.innerText = 'VIEW MORE';

  if(productBtn !== null) {
    productBtn.remove();
  }

  while(PRODUCT_START_POS < limit && PRODUCT_FETCH_MAX === false) {
    let product = new FeedProduct('1',
                                  'Product', 
                                  '0', 
                                  'Partner', 
                                  '../../assets/images');

    // console.log(product);
    
    productFeed.appendChild(product);

    PRODUCT_START_POS++;

    if(PRODUCT_START_POS === PRODUCT_TOTAL_NUM) {
      PRODUCT_FETCH_MAX = true;
    }
  }

  PRODUCT_FETCH_MAX === true ? productFeed.append(FeedProduct.maxMessage()) :   
                               productFeed.append(productFetchBtn);
}