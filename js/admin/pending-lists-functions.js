window.onload = () => {
  createPPList();
  createPLList();
}

function createPPList() {
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

function createPLList() {
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