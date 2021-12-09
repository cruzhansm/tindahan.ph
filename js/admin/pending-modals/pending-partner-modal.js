window.showModal = function showModal(selectedModal, applicationId) {
  const modal = new bootstrap.Modal(selectedModal);
  const modalBody = document.querySelector('.partner-modal-body');

  modal.show();
  getPendingPartnerDetails(applicationId, modalBody);

  console.log(applicationId);
};

window.dismissModal = function dismissModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const form = selectedModal.querySelector('form');

  resetFlags().then(stripInputListeners(form)).then(removeAllValidation(form));

  modal.hide();
};

function getPendingPartnerDetails(applicationId, modalBody) {
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
