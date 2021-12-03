export async function navigation() {
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
