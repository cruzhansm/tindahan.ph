window.onload = () => {
  const data = new URLSearchParams(window.location.search);

  let ctype = data.get('c');

  retrieveTitle(ctype);
  retrieveProducts(ctype);
  
}

function retrieveTitle(category) {
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

function retrieveProducts(category) {
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
      
      results.forEach( x => {
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