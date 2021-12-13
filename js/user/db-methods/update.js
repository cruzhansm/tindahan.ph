export async function cancelSpecifiedOrder(orderID) {
  return await $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/orders/crud.php',
    data: {
      type: 'cancel-order',
      orderID: orderID,
    },
    success: (result) => {
      result = JSON.parse(result);

      return result;
    },
  });
}
