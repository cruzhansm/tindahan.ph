export async function getProductDetails(productID) {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/products/crud.php',
    data: {
      type: 'retrieve-product',
      productID: productID,
    },
    success: (product) => {
      product = JSON.parse(product);

      return product;
    },
  });
}

export async function getCurrentRole() {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/user/crud.php',
    data: {
      type: 'retrieve-user-role',
    },
    success: (result) => {
      result = JSON.parse(result);

      return result;
    },
  });
}

export async function getCurrentUser() {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/user/crud.php',
    data: {
      type: 'retrieve-user-id',
    },
    success: (result) => {
      result = JSON.parse(result);

      return result;
    },
  });
}
