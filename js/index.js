// import { navigation } from './common/navigation/nav.js';

window.onload = function () {
  const view = new URLSearchParams(window.location.search);

  // navigation().then((resolve) => {
  new Promise(function (resolve, reject) {
    $.ajax({
      type: 'GET',
      url: '/tindahan.ph/php/utype.php',
      success: (result) => {
        resolve(result);
      },
    });
  }).then((resolve) => {
    if (!view.has('u')) {
      window.location.href = `${window.location.href}?u=${resolve}`;
    }

    if (view.get('u') == 'user' || view.get('u') == 'partner') {
      fetchProductsByBatch();
      attachMessagingEventListener();
    }
  });
};
