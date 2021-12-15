import { createLiveListing } from './db-methods/retrieve.js';

export var LISTINGS = new Array();

window.onload = async () => {
  const listingsCatcher = JSON.parse(await createLiveListing());
  appendListingTab(listingsCatcher);
};

function appendListingTab(listingsCatcher) {
  let listingsList = document.getElementById('admin-listings-list');
  LISTINGS = listingsCatcher;
  console.log(LISTINGS);
  listingsCatcher.forEach((x, index) => {
    listingsList.innerHTML += `<div class="admin-user">
        <div class="admin-user-info" style="width: 600px">
          <div class="admin-user-info-highlight">
            <img src='${x.products.product_img}' class="admin-user-img"></img>
            <div class="admin-user-name">${x.products.product_name}</div>
          </div>
          <span class="admin-user-role">${x.store}</span>
          <span class="admin-user-id">${x.products.product_id}</span>
        </div>
        <div class="admin-user-actions" style="width: 375px">
          ${
            x.products.suspended == 'false'
            ? `<button class="btn btn-tertiary" onclick="showProdModal(suspendModal, ${x.products.product_id}, ${index})">Suspend</button>`
            : `<span class="tph-disabled">SUSPENDED</span>`
          }
          <button class="btn btn-tertiary" onclick="showDeleteModal(deleteModal, ${x.products.product_id}, ${index})">Delete</button>
        </div>
      </div>`;
  });
}
