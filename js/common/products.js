class Product {
  productID;
  productName;
  productImg;
  productPrice;
  productDesc;

  constructor(productID, productName, productImg, productPrice, productDesc) {
    this.productID = productID;
    this.productName = productName;
    this.productImg = productImg;
    this.productPrice = productPrice;
    this.productDesc = productDesc;
  }
}

class FeedProduct extends Product {
  constructor(productID, productName, productImg, productPrice, productDesc) {
    super(productID, productName, productImg, productPrice, productDesc);

    return this.#createFeedProduct();
  }

  #createFeedProduct() {
    let feedBlock = document.createElement('div');
    let feedImg = document.createElement('div');
    let feedInfo = document.createElement('div');
    let feedName = document.createElement('div');
    let feedPrice = document.createElement('div');
    // let feedStore = document.createElement('div');

    feedBlock.classList.add('product-feed-block');
    feedImg.classList.add('product-feed-img');
    feedInfo.classList.add('product-feed-info');
    feedPrice.classList.add('product-feed-price');
    // feedStore.classList.add('product-feed-store');

    feedName.innerText = this.productName;
    feedPrice.innerText = `P ${this.productPrice}`;
    // feedStore.innerText = this.pstore;

    feedInfo.appendChild(feedName);
    feedInfo.appendChild(feedPrice);

    feedBlock.appendChild(feedImg);
    feedBlock.appendChild(feedInfo);
    // feedBlock.appendChild(feedStore);

    return feedBlock;
  }

  static maxMessage() {
    let message = document.createElement('div');

    message.classList.add('d-block', 'mx-auto', 'fs-20');
    message.style.cssText = `color: #64798B;
                             min-width: max-content;
                             margin-top: 54px;`;
    message.innerText = 'You have reached the end of the page.';

    return message;
  }
}
