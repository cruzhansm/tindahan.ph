export async function userHasApplied() {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: 'GET',
      url: '/tindahan.ph/php/user/crud.php',
      data: {
        type: 'partner-application-check',
      },
      success: (result) => {
        result = JSON.parse(result);

        resolve(result);
      },
    });
  });
}
