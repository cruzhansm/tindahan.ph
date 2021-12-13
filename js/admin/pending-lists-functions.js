import { createPPList } from '/tindahan.ph/js/admin/db-methods/retrieve.js'
import { createListingsList } from '/tindahan.ph/js/admin/db-methods/retrieve.js'

export var APPLICATIONS = new Array();
export var LISTING_APPLICATIONS = new Array();

window.onload = async () => {
  
  const ppCatch = JSON.parse(await createPPList());
  appendPPList(ppCatch);

  const listingCatch = JSON.parse(await createListingsList());
  appendListingsList(listingCatch);

}

//  Outputs pending partners tabs (complete)
function appendPPList(ppCatch) {
  let ppList = document.getElementById('pending-partners-list');
  APPLICATIONS = ppCatch;
  console.log(APPLICATIONS);
  ppCatch.forEach(x => {
  ppList.innerHTML +=
    `<div class="admin-pending-item" id="a${x.application_id}" onclick="showModal(pendingPartnerProfile, ${x.application_id})">
      <div class="admin-pending-item-info">
        <img src='${x.store_img}' class="admin-pending-item-img partner">
        <div class="details">
          <span class="admin-pending-item-main">${x.store_name}</span>
          <span class="admin-pending-item-sub">${x.store_main_categ}</span>
        </div>
      </div>
      <div class="admin-pending-item-actions">
        <div class="admin-reject">
          <i class="fa-solid fa-x" onclick="rejectedTab(${x.application_id})" type="submit" id="admin-reject-item"></i>
        </div>
        <div class="admin-accept">
          <i class="fa-solid fa-check" onclick="approvedTab(${x.application_id})" type="submit" id="admin-approve-item"></i>
        </div>
      </div>
    </div>
    `;
  })
}

//  Outputs pending listings tabs (complete)
function appendListingsList(listingCatch) {
  let ListingsList = document.getElementById('pending-listings-list');
  LISTING_APPLICATIONS = listingCatch;
  console.log(LISTING_APPLICATIONS);
  listingCatch.forEach((pl, index) => {
  ListingsList.innerHTML +=
    `<div class="admin-pending-item" id="b${pl.application.application_id}" onclick="listingShowModal(pendingListingProfile, ${pl.application.application_id}, ${index})">
      <div class="admin-pending-item-info">
        <img src='${pl.application.listing_img}' class="admin-pending-item-img">
        <div class="details">
          <span class="admin-pending-item-main">${pl.application.listing_name}</span>
          <span class="admin-pending-item-sub">${pl.application.listing_brand}</span>
        </div>
      </div>
      <div class="admin-pending-item-actions">
        <div class="admin-reject">
          <i class="fa-solid fa-x" onclick="listingRejectedTab(${index})"></i>
        </div>
        <div class="admin-accept">
          <i class="fa-solid fa-check" onclick="listingApprovedTab(${index})"></i>
        </div>
      </div>
    </div>`
  })
}