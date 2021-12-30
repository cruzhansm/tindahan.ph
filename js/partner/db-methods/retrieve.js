export async function fetchStoreDetails() {
  const id = new URLSearchParams(window.location.search).get('id');

  if (id != null) {
    return await $.ajax({
      type: 'GET',
      url: '/tindahan.ph/php/partner/crud.php',
      data: {
        type: 'retrieve-store-w-id',
        storeID: id,
      },
      success: (result) => {
        result = JSON.parse(result);
        return result;
      },
    });
  } else {
    return await $.ajax({
      type: 'GET',
      url: '/tindahan.ph/php/partner/crud.php',
      data: {
        type: 'retrieve-store-details',
      },
      success: (result) => {
        result = JSON.parse(result);
        return result;
      },
    });
  }
}

export async function retrieveAllStoreOrders() {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/orders/crud.php',
    data: {
      type: 'retrieve-store-orders',
    },
    success: (result) => {
      result = JSON.parse(result);

      return result;
    },
  });
}

export async function retrieveStoreProducts(storeID) {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/partner/crud.php',
    data: {
      type: 'retrieve-store-products',
      storeID: storeID,
    },
    success: (result) => {
      result = JSON.parse(result);
      return result;
    },
  });
}

export async function retrieveListingDetails(productID) {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/products/crud.php',
    data: {
      type: 'retrieve-single-listing',
      productID: productID,
    },
    success: (result) => {
      result = JSON.parse(result);

      return result;
    },
  });
}
