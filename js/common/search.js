window.onload = () => {
  if (window.location.href.includes('search.html')) {
    const search = new URLSearchParams(window.location.search).get('q');
    const searchTitle = document.querySelector('#sq');

    // REFACTOR
    // Once backend is done, revert to false and do a search query
    // If search string is found, assign true and update query title
    const validSearch = search != null ? true : false;

    // Should be true or false depending if there are products found
    let searchFound = true;

    // REFACTOR
    // Change to another appropriate function that appends select products only
    if (validSearch && searchFound) {
      searchTitle.innerText = `"${search}"`;
    } else {
      searchTitle.parentElement.innerHTML = 'Results';
    }
  }
};

function search(event) {
  const query = event.target.firstElementChild.value;
  let redirect = '/tindahan.ph/src/common/search.html';

  event.preventDefault();

  window.location.href = query.length > 0 ? `${redirect}?q=${query}` : redirect;
}
