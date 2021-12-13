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

export function createPPList() {
  let ppList = document.getElementById('pending-partners-list');

  $.ajax({
    url: '/tindahan.ph/php/partner-applications/crud.php',
    data: {
      type: 'create-pending-partners-list'
    },
    success: (data) => {
      let result = JSON.parse(data);
      result.forEach(x => {
        ppList.innerHTML +=
        `<div class="admin-pending-item">
        <div class="admin-pending-item-info">
          <img src='${x.store_img}' class="admin-pending-item-img partner">
          <div class="details">
            <span class="admin-pending-item-main" onclick="showModal(pendingPartnerProfile, ${x.application_id})">${x.store_name}</span>
            <span class="admin-pending-item-sub">${x.store_main_categ}</span>
          </div>
        </div>
        <div class="admin-pending-item-actions">
          <div class="admin-reject">
            <i class="fa-solid fa-x" role="button" type="submit" id="admin-reject-item"></i>
          </div>
          <div class="admin-accept">
            <i class="fa-solid fa-check" role="button" type="submit" id="admin-approve-item"></i>
          </div>
        </div>
      </div>`;
      })
    }
  });
}

export function createPLList() {
  let plList = document.getElementById('pending-listings-list');

  $.ajax({
    url: '../../php/admin/crud.php',
    data: {
      type: 'create-pending-listings-list'
    },
    success: (data) => {
      let result = JSON.parse(data);
      result.forEach(x => {
        plList.innerHTML +=
        `<div class="admin-pending-item">
        <div class="admin-pending-item-info">
          <img src='${x.listing_img}' class="admin-pending-item-img">
          <div class="details">
            <span class="admin-pending-item-main">${x.listing_name}</span>
            <span class="admin-pending-item-sub">${x.listing_brand}</span>
          </div>
        </div>
        <div class="admin-pending-item-actions">
          <div class="admin-reject">
            <i class="fa-solid fa-x"></i>
          </div>
          <div class="admin-accept">
            <i class="fa-solid fa-check"></i>
          </div>
        </div>
      </div>`;
      })
    }
  })
}

export function getPendingPartnerDetails(applicationId, modalBody) {
  $.ajax({
    type: 'POST',
    url: '../../php/admin/crud.php',
    data: {
      type: 'show-pending-partners-details',
      partnerId: applicationId
    },
    success: (data) => {
      let result = JSON.parse(data);
      modalBody.innerHTML = "";
      modalBody.innerHTML +=
      `<div class="partner-modal-body mx-auto">
      <div class="partner-modal-top">
        <div class="partner-modal-top-title">
          <div class="partner-modal-top-image"><img src='${result.store_img}'></div>
          <div class="partner-names">
            <p class="store-name">${result.store_name}</p>
            <p>${result.store_main_categ}</p>
          </div>
        </div>
      </div>
      <div class="partner-modal-details">
        <div class="new-to-selling">
          <p>New to Selling? <span>${result.online_experience}</span></p>
          <p>${result.online_platforms}</p>
        </div>
        <div class="short-description">
          <p>Short Description:</p>
          <p>${result.store_desc}</p>
        </div>
        <div class="partner-pictures">
          <p>Picture:</p>
          <img src='${result.store_img}'>
        </div>
        <div class="shop-modal-button-group">
          <button
            type="button"
            class="btn btn-tertiary"
            data-bs-dismiss="modal"
            onclick="dismissModal(pendingPartnerProfile)"
          >
            Reject
          </button>
          <button
            type="submit"
            class="btn btn-primary"
            onclick="showModal(pendingPartnerProfile)"
          >
            Approve
          </button>
        </div>
      </div>
    </div>`;
    }
  });
}

export function createUserList() {
    return $.ajax({
      type: 'GET',
      url: '/tindahan.ph/php/user/crud.php',
      data: {
        type: 'create-user-tabs'
      },
      success: (data) => {
        let result = JSON.parse(data);
        return result;
      }
    })
}

export function suspendModalInfo(user, modalBody) {
  modalBody.innerHTML = ""
  modalBody.innerHTML +=
    `<div class="listing-modal-body mx-auto">
      <div class="listing-modal-top">
        <div class="listing-modal-top-title">
          <div class="listing-names">
            <span class="store-name fw-bold fs-24 text-center">Are you sure?</span>
          </div>
        </div>
      </div>
      <div class="listing-modal-details text-center">
        <div class="listing-details">
          <span>
          Suspending <span class="modal-name">${user.fname} ${user.lname}</span> will mean they will be unable to use tindahan.ph's services for 7 days.
          </span>
        </div>
        
      </div>
      
    </div>
    <div class="shop-modal-button-group listing-modal-btn-group">
          <button
            type="button"
            class="btn btn-tertiary"
            onclick="dismissSuspendModal(suspendModal)"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="btn btn-primary"
            // onclick="suspendedModal(suspendModal, ${user.user_id})"
          >
            Suspend
          </button>
        </div>`
}

export function deleteModalInfo(user, modalBody) {
  modalBody.innerHTML = ""
  modalBody.innerHTML +=
    `<div class="listing-modal-body mx-auto">
      <div class="listing-modal-top">
        <div class="listing-modal-top-title">
          <div class="listing-names">
            <span class="store-name fw-bold fs-24 text-center">Are you sure?</span>
          </div>
        </div>
      </div>
      <div class="listing-modal-details text-center">
        <div class="listing-details">
          <span>
          Deleting <span class="modal-name">${user.fname} ${user.lname}</span> will mean they will not be able to access tindahan.ph indefinitely.
          </span>
        </div>
        
      </div>
      
    </div>
    <div class="shop-modal-button-group listing-modal-btn-group">
          <button
            type="button"
            class="btn btn-tertiary"
            onclick="dismissDeleteModal(deleteModal)"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="btn btn-primary"
            // onclick="deletedModal(deleteModal, ${user.user_id})"
          >
            Delete
          </button>
        </div>`
}