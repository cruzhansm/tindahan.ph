export function retrieveTitle(category) {
  const title = document.querySelector('.product-title');

  $.ajax({
    type: 'POST',
    url: '../../php/common/crud.php',
    data: {
      type: 'title',
      id: category,
    },
    success: (data) => {
      console.log(data);
      title.innerHTML += `${data}`;
    },
  });
}

export function retrieveProducts(category) {
  const productFeed = document.querySelector('.container-product-feed');

  $.ajax({
    type: 'POST',
    url: '../../php/common/crud.php',
    data: {
      type: 'products-results',
      category: category,
    },
    success: (data) => {
      // console.log(data);
      let results = JSON.parse(data);

      results.forEach((x) => {
        productFeed.innerHTML += `<a href='/tindahan.ph/src/common/product.php?id=${x.product_id}' class="product-feed-block">
        <img src="${x.product_img}" class="product-feed-img" />
        <div class="product-feed-info">
          <div>${x.product_name}</div>
          <div class="product-feed-price">${x.product_price}</div>
        </div>
        <div class="product-feed-store">${x.product_store.store_name}</div>
      </a>`;
      });
    },
  });
}

export function retrieveCategories() {
  const container = document.getElementById('categories-table');

  $.ajax({
    type: 'POST',
    url: '../../php/common/crud.php',
    data: {
      type: 'retrieve-categories',
    },
    success: (data) => {
      let resultData = JSON.parse(data);
      console.log(resultData);
      resultData.forEach((x) => {
        container.innerHTML += `<a href='../common/categories-results.php?c=${x.category_id}' class='categories-box'>
          <img src='${x.category_img}' class='categories-box-img'>
          <div class='categories-box-title'>${x.category_name}</div>
        </a>`;
      });
    },
  });
}

export async function validateSettings(password) {
  return await $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/common/crud.php',
    data: {
      type: 'validate-settings',
      pass: password,
    },
    success: (data) => {
      data = JSON.parse(data);
      console.log(data);

      return data;
    },
  });
}

export async function initializeInfoSettings() {
  return await $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/common/crud.php',
    data: {
      type: 'initialize-info',
    },
    success: (data) => {
      data = JSON.parse(data);
      console.log(data);

      return data;
    },
  });
}

export function fetchUserDetails() {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: 'POST',
      url: '/tindahan.ph/php/common/crud.php',
      data: {
        type: 'get-user-details',
      },
      success: (data) => {
        data = JSON.parse(data);
        resolve(data);
      },
    });
  });
}

export async function fetchSearchResults(query) {
  const result = document.querySelector('#sq');
  return await $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/common/crud.php',
    data: {
      type: 'search',
      search_query: query,
    },
    success: (data) => {
      // console.log(data);
      data = JSON.parse(data);

      result.innerHTML = query;
      return data;
    },
  });
}

export async function fetchMultipleProducts() {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/products/retrieve.php',
    data: {
      type: 'multiple-random',
      num: 60,
    },
    success: (result) => {
      // console.log(result);
      result = JSON.parse(result);
      return result;
    },
  });
}
