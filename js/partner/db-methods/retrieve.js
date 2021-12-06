export function fetchStoreDetails() {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: 'GET',
      url: '/tindahan.ph/php/partner/crud.php',
      data: {
        type: 'retrieve-store-details',
      },
      success: (result) => {
        result = JSON.parse(result);
        console.log(result);
        resolve(result);
      },
    });
  });
}
