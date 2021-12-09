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
