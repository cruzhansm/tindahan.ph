export function countActiveUsers() {
  let activeUsers = document.getElementById('active-users');

  $.ajax({
    url: '../../php/admin/crud.php',
    data: {
      type: 'count-users'
    },
    success: (data) => {
      activeUsers.innerHTML += `${data}`
    }
  });
}

export function countPendingPartners() {
  let pendingPartners = document.getElementById('pending-partners');
  
  $.ajax({
    url: '../../php/admin/crud.php',
    data: {
      type: 'count-pending-partners'
    },
    success: (data) => {
      pendingPartners.innerHTML += `${data}`
    }
  });
}

export function countPendingListings() {
  let pendingListings = document.getElementById('pending-listings');

  $.ajax ({
    url: '../../php/admin/crud.php',
    data: {
      type: 'count-pending-listings'
    },
    success: (data) => {
      pendingListings.innerHTML += `${data}`
    }
  });
}

//  Creates the pending partners tabs
export async function createPPList() {
  let ppList = document.getElementById('pending-partners-list');

  return await $.ajax({
    url: '/tindahan.ph/php/partner-applications/crud.php',
    data: {
      type: 'create-pending-partners-list'
    },
    success: (data) => {
      let result = JSON.parse(data);
      return result;
    }
  });
}

//  Creates the pending listings tabs
export async function createListingsList() {
  let ListingsList = document.getElementById('pending-listings-list');

  return await $.ajax({
    url: '/tindahan.ph/php/listing-applications/crud.php',
    data: {
      type: 'create-pending-listings-list'
    },
    success: (data) => {
      let result = JSON.parse(data);
      console.log(result);
      return result;
    }
  })
}

//  Fetching PP data to show in modal
export function getPendingPartnerDetails(application, modalBody) {
  console.log(application);  
  modalBody.innerHTML = "";
    modalBody.innerHTML +=
      `<div class="partner-modal-body mx-auto">
        <div class="partner-modal-top">
          <div class="partner-modal-top-title">
            <div class="partner-modal-top-image"><img src='${application.store_img}'></div>
            <div class="partner-names">
              <span class="store-name fw-bold fs-24">${application.store_name}</span>
              <span class="text-secondary fs-18">${application.store_main_categ}</span>
            </div>
          </div>
        </div>
        <div class="partner-modal-details">
          <div class="new-to-selling">
            <span>New to Selling? <span class="text-secondary fs-18">${application.online_experience  == "yes" ? "No" : "Yes"}</span></span>
            <div class="text-answer">${application.online_platforms}</div>
          </div>
          <div class="short-description">
            <span>Short Description:</span>
            <div class="text-answer">${application.store_desc}</div>
          </div>
          
        </div>
        
      </div>
      <div class="shop-modal-button-group listing-modal-btn-group">
            <button
              type="button"
              class="btn btn-tertiary"
              onclick="rejectedModal(pendingPartnerProfile, ${application.application_id})"
            >
              Reject
            </button>
            <button
              type="submit"
              class="btn btn-primary"
              onclick="approvedModal(pendingPartnerProfile, ${application.application_id})"
            >
              Approve
            </button>
          </div>
      `;
}

//  Fetching PL data to show in modal
export function getPendingListingDetails(application, modalBody, index) {
  modalBody.innerHTML = ""
  modalBody.innerHTML +=
  `<div class="listing-modal-body mx-auto">
        <div class="listing-modal-top">
          <div class="listing-modal-top-title">
            <div class="listing-modal-top-image"><img src='${application.application.listing_img}'></div>
            <div class="listing-names">
              <span class="store-name fw-bold fs-24">${application.application.listing_name}</span>
              <span class="text-secondary fs-18">${application.categories.join(', ')}</span>
            </div>
          </div>
        </div>
        <div class="listing-modal-details">
          <div class="new-to-selling">
            <span>Brand: <span class="text-secondary fs-18">${application.application.listing_brand}</span></span>
          </div>
          <div class="listing-variations">
            <span>Variations: <span class="text-secondary fs-18">${application.variation.join(', ')}</span></span>
          </div>
          <div class="short-description">
            <span>Description:</span>
            <div class="text-answer">${application.application.listing_desc}</div>
          </div>
          
        </div>
        
      </div>
      <div class="shop-modal-button-group listing-modal-btn-group">
            <button
              type="button"
              class="btn btn-tertiary"
              onclick="listingRejectedModal(pendingListingProfile, ${index})"
            >
              Reject
            </button>
            <button
              type="submit"
              class="btn btn-primary"
              onclick="listingApprovedModal(pendingListingProfile, ${application})"
            >
              Approve
            </button>
          </div>
      `
}