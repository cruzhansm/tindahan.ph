import { StatusModal } from '../../common/modal/status-modal.js';

export function insertPartnerApplication(application) {
  let data = new FormData();

  data.append('application', JSON.stringify(application));
  data.append('type', 'partner-application');
  data.append('file', application.storeImg);

  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/partner-applications/crud.php',
    data: data,
    processData: false,
    contentType: false,
    success: (result) => {
      result = JSON.parse(result);

      if (result === true) {
        const test = new StatusModal('Sent!');
        test.show();
        test.dismissAfter(500);
        console.log('HOY BAHOG BILAT');
      } else {
        alert(result.error_msg);
      }
    },
  });
}
