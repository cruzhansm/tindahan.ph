import { noSubmit } from '../../common/input/form.js';
import { fetchStoreDetails } from '../db-methods/retrieve.js';

var STORE = (window.onload = () => {
  fetchStoreDetails().then((store) => appendShopDetails(store));
});

function appendShopDetails(store) {
  STORE = store;

  const shopName = document.querySelector('#shopName');
  const shopImg = document.querySelector('#shopImg');
  const shopDesc = document.querySelector('#shopDesc');
  const shopRating = document.querySelector('#shopRating');
  const shopAddress = document.querySelector('#shopAddress');
  const shopContact = document.querySelector('#shopContact');

  shopName.innerText = store.store_name;
  shopImg.setAttribute('src', store.store_img);
  shopDesc.innerText = store.store_description;
  shopRating.innerText = store.store_rating;
  shopAddress.innerText =
    store.store_address != ', ' ? store.store_address : 'Not yet set';
  shopContact.innerText =
    store.store_contact != null ? `+63 ${store.store_contact}` : 'Not yet set';
}

window.attemptEditProfile = function attemptEditProfile(event) {
  noSubmit(event);

  const address =
    document.querySelector('#partnerCity').value +
    document.querySelector('#partnerBarangay').value;

  const editDetails = {
    storeName: document.querySelector('#partnerName').value,
    storeDesc: document.querySelector('#editProfileMsg').value,
    storeAddress: address,
    storeContact: document.querySelector('#partnerContact').value,
  };

  for (let detail in editDetails) {
    console.log(editDetails[detail].length);
  }
};
