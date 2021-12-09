export function retrieveTitle(category) {
  const title = document.querySelector('.product-title');

  $.ajax({
    type: 'POST',
    url: '../../php/common/crud.php',
    data: {
      type: 'title',
      id: category
    },
    success: (data) => {
      console.log(data);
      title.innerHTML += `${data}`;
    }
  });
}

export function retrieveProducts(category) {
  const productFeed = document.querySelector('.container-product-feed');

  $.ajax({
    type: 'POST',
    url: '../../php/common/crud.php',
    data: {
      type: 'products-results',
      category: category
    },
    success: (data) => {
      console.log(data);
      let results = JSON.parse(data);

      results.forEach(x => {
        productFeed.innerHTML +=
          `<a href='/tindahan.ph/src/common/product-page.php?id=${x.product_id}' class="product-feed-block">
        <img src="${x.product_img}" class="product-feed-img" />
        <div class="product-feed-info">
          <div>${x.product_name}</div>
          <div class="product-feed-price">${x.product_price}</div>
        </div>
        <div class="product-feed-store">${x.product_store.store_name}</div>
      </a>`
      })
    }
  });
}

export function retrieveCategories() {
  const container = document.getElementById('categories-table');

  $.ajax({
    type: 'POST',
    url: '../../php/common/crud.php',
    data: {
      type: 'retrieve'
    },
    success: (data) => {
      console.log('hello');
      let resultData = JSON.parse(data);
      console.log(resultData);
      resultData.forEach(x => {
        container.innerHTML +=
          `<a href='../common/categories-results.php?c=${x.category_id}' class='categories-box'>
          <img src='${x.category_img}' class='categories-box-img'>
          <div class='categories-box-title'>${x.category_name}</div>
        </a>`

      })
    }
  });
}