import { noSubmit } from '/tindahan.ph/js/common/input/form.js';

window.search = function search(event) {
  noSubmit(event);
  const query = event.target.firstElementChild.value;
  let redirect = '/tindahan.ph/src/common/search.php';

  window.location.href = query.length > 0 ? `${redirect}?q=${query}` : redirect;
};
