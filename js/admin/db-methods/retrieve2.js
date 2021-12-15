export async function createLiveListing() {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/products/crud.php',
    data: {
      type: 'create-listing-tabs',
    },
    success: (data) => {
      let result = JSON.parse(data);
      return result;
    },
  });
}

export function suspendProdModal(product, modalBody, index) {
  modalBody.innerHTML = '';
  modalBody.innerHTML += `<div class="listing-modal-body mx-auto">
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
          Suspending the item,<span class="modal-name">${product.products.product_name},</span> will mean it cannot be seen nor bought for 7 days.
          </span>
        </div>
        
      </div>
      
    </div>
    <div class="shop-modal-button-group listing-modal-btn-group">
          <button
            type="button"
            class="btn btn-tertiary"
            onclick="dismissProdModal(suspendModal)"
          >
            Cancel
          </button>
          <button
            type="submit"
            class="btn btn-primary"
            onclick="suspendedProdModal(suspendModal, ${product.products.product_id}, ${index})"
          >
            Suspend
          </button>
        </div>`;
}

export function deleteProdModal(product, modalBody, index) {
  modalBody.innerHTML = '';
  modalBody.innerHTML += `<div class="listing-modal-body mx-auto">
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
          Deleting <span class="modal-name">${product.products.product_name}</span> will mean it will be removed from tindahan.ph indefinitely.
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
            // onclick="deletedProdModal(deleteModal, ${index})"
          >
            Delete
          </button>
        </div>`;
}
