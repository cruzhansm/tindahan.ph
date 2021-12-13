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
      console.log(data);
      let results = JSON.parse(data);

      results.forEach((x) => {
        productFeed.innerHTML += `<a href='/tindahan.ph/src/common/product-page.php?id=${x.product_id}' class="product-feed-block">
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
      console.log('hello');
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

export function validateSettings(password) {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: 'POST',
      url: '/tindahan.ph/php/common/crud.php',
      data: {
        type: 'validate-settings',
        pass: password,
      },
      success: (data) => {
        data = JSON.parse(data);
        console.log(data);
        if (data == true) {
          resolve(data);
        } else {
          reject(data);
        }
      },
    });
  });
}

export function initializeInfoSettings() {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/common/crud.php',
    data: {
      type: 'initialize-info',
    },
    success: (data) => {
      data = JSON.parse(data);
      console.log(data);

      const city = document.getElementById('user-city');
      const barangay = document.getElementById('user-barangay');
      const street = document.getElementById('user-street');
      const zipcode = document.getElementById('user-zipcode');
      const landmark = document.getElementById('user-landmark');
      const phone = document.getElementById('user-contact');
      const email = document.getElementById('accountUserEmail');

      document.getElementById('previewImg').setAttribute('src', data.image);
      document.getElementById('user-fName').value = data.fname;
      document.getElementById('user-lName').value = data.lname;
      data.city == null || data.city == ''
        ? (city.placeholder = 'Not yet set')
        : (city.value = data.city);
      data.barangay == null || data.barangay == ''
        ? (barangay.placeholder = 'Not yet set')
        : (barangay.value = data.barangay);
      data.street == null || data.street == ''
        ? (street.placeholder = 'Not yet set')
        : (street.value = data.street);
      data.zipcode == null || data.zipcode == ''
        ? (zipcode.placeholder = 'Not yet set')
        : (zipcode.value = data.zipcode);
      data.landmark == null || data.landmark == ''
        ? (landmark.placeholder = 'Not yet set')
        : (landmark.value = data.landmark);
      data.phone == null || data.phone == 0
        ? (phone.placeholder = 'Not yet set')
        : (phone.value = data.phone);

      email.innerHTML = `${data.email}`;
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
