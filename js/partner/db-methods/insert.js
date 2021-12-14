export async function insertListingApplication(application) {
  return await $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/listing-applications/crud.php',
    data: {
      type: 'insert-new-listing',
      application: JSON.stringify(application),
    },
    success: (result) => {
      // console.log(result);
      result = JSON.parse(result);

      return result;
    },
  });
}
