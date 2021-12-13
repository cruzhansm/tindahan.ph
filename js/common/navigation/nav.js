export async function navigateToHome() {
  return new Promise(function (resolve, reject) {
    $.ajax({
      type: 'GET',
      url: '/tindahan.ph/php/utype.php',
      success: (result) => {
        resolve(result);
      },
    });
  });
}
