import { fetchStoreDetails } from '../db-methods/retrieve.js';

export var STORE = new Object();

window.onload = () => {
  fetchStoreDetails().then((store) => {
    STORE = store;
    appendShopDetails(store);
  });
};

function appendShopDetails(store) {
  const shopName = document.querySelector('#shopName');
  const shopImg = document.querySelector('#shopImg');
  const shopDesc = document.querySelector('#shopDesc');
  const shopAddress = document.querySelector('#shopAddress');
  const shopContact = document.querySelector('#shopContact');

  shopName.innerText = store.store_name;
  shopImg.setAttribute('src', store.store_img);
  shopDesc.innerText = store.store_description;
  shopAddress.innerText =
    store.store_address != ', ' ? store.store_address : 'Not yet set';
  shopContact.innerText =
    store.store_contact != null ? `+63 ${store.store_contact}` : 'Not yet set';
}

export function initializeModalData(store) {
  const form = document.querySelector('form');
  const address = store.store_address.split(', ');

  const actualData = [
    store.store_img,
    store.store_name,
    store.store_description,
    address[1],
    address[0],
    store.store_contact,
  ];

  Array.from(form.elements).forEach((elem, index) => {
    if (elem.localName.localeCompare('button') != 0 && index != 0) {
      elem.value = actualData[index];
    }

    if (index == 0) {
      const target = document.querySelector('#previewImg');

      target.setAttribute('src', store.store_img);
    }
  });
}
