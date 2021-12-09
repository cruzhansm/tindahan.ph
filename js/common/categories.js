import { retrieveCategories } from '../common/db-methods/retrieve.js'

window.onload = () => {
  retrieveCategories();

  new Promise(function (resolve, reject) {
    $.ajax({
      type: 'GET',
      url: '/tindahan.ph/php/utype.php',
      success: (result) => {
        resolve(result);
      },
    });
  }).then((resolve) => {
    const test = document.querySelector(`#${resolve}1`);
    const test2 = document.querySelector(`#${resolve}1`);

    test.classList.remove('visually-hidden');
    test2.classList.remove('visually-hidden');
  });
}