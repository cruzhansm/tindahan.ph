export async function deleteVariation(variationID) {
  return await $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/products/crud.php',
    data: {
      type: 'delete-single-variation',
      variationID: variationID,
    },
    success: (result) => {
      result = JSON.parse(result);

      return result;
    },
  });
}
