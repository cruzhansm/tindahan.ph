import { retrieveListingDetails } from '../db-methods/retrieve.js';
import {
  attachEmptyFieldListeners,
  disableSubmitBtn,
  enableSubmitBtn,
  noSubmit,
} from '../../common/input/form.js';
import { StatusModal } from '../../common/modal/status-modal.js';
import { deleteVariation } from '../db-methods/delete.js';
import { attachCharCountListener } from '../../common/input/input.js';
import { updateListingDetails } from '../db-methods/update.js';

var LISTING = new Object();

window.onload = async () => {
  const productID = new URLSearchParams(window.location.search).get('id');

  const listing = JSON.parse(await retrieveListingDetails(productID));
  console.log(listing);
  LISTING = listing;

  appendListingInformation(listing);

  const form = document.querySelector('form');

  disableSubmitBtn(form)
    .then(attachEmptyFieldListeners('file'))
    .then(attachEmptyFieldListeners('input'))
    .then(attachEmptyFieldListeners('textarea'))
    .then(attachCharCountListener(shdesc, shdescMsgCount));
};

window.previousPage = function previousPage() {
  window.history.back();
};

function appendListingInformation(listing) {
  const previewImg = document.querySelector('#previewImg');
  const listingName = document.querySelector('#listingName');
  const listingPrice = document.querySelector('#listingPrice');
  const listingCategory = document.querySelector('#listingCategory');
  const listingDesc = document.querySelector('#shdesc');
  const listingBrand = document.querySelector('#listingBrand');
  const listingStock = document.querySelector('#listingStock');

  const categ = Array.from(document.querySelectorAll('option')).filter(
    (o) => o.innerText == listing.product_categories[0]
  )[0].value;

  previewImg.setAttribute('src', listing.product_img);
  previewImg.classList.remove('visually-hidden');
  listingName.value = listing.product_name;
  listingPrice.value = parseInt(listing.product_price);
  listingCategory.value = categ;
  listingDesc.value = listing.product_desc;
  listingBrand.value = listing.product_brand;
  listingStock.value = listing.product_quantity;
  appendVariations(listing.product_variations);
}

function appendVariations(variations) {
  console.log(variations);

  const target = document.querySelector('#variationList');

  variations.forEach((variation) => {
    let append = document.createElement('div');
    append.classList.add('row', 'variation-row');
    append.setAttribute('id', `v${variation.variation_id}`);

    append.innerHTML += `
    <div class="col-auto p-0">
      <input
        class="
          form-control
          border-input
          variation-name
          "
        value="${variation.variation}"
        type="text"
        placeholder="Variation"
      />
    </div>

    <div class="col-auto p-0">
      <input
        class="
          form-control
          stock-input
          border-input
          variation-price
          "
        value=${parseInt(variation.price)}
        type="number"
        min="1"
        max="9999"
        minlength="1"
        maxlength="4"
        placeholder="Price"
      />
    </div>

    <div class="col-auto p-0">
      <input
        class="
          form-control
          stock-input
          border-input
          variation-stock
        "
        value=${parseInt(variation.quantity)}
        type="number"
        min="1"
        max="9999"
        minlength="1"
        maxlength="4"
        placeholder="Stock"
      />
    </div>

    <div class="col-auto p-2 my-auto">
      <i class="fa-solid fa-trash-can" onclick="deleteVariation(${
        variation.variation_id
      })"></i>
    </div>
    `;
    target.append(append);
  });
}

window.addNewVariation = function addNewVariation() {
  const target = document.querySelector('#variationList');
  const append = document.createElement('div');
  let id = Array.from(document.querySelectorAll('.variation-row'));
  id =
    id[id.length - 1] != null
      ? parseInt(id[id.length - 1].id.toString().slice(1)) + 1
      : id.length;
  append.classList.add('row', 'variation-row');
  append.setAttribute(`id`, `v99${id}`);

  append.innerHTML += `
    <div class="col-auto p-0">
      <input
        class="
          form-control
          border-input
          not-required
          variation-name
        "
        type="text"
        placeholder="Variation"
      />
    </div>

    <div class="col-auto p-0">
      <input
        class="
          form-control
          stock-input
          border-input
          not-required
          variation-price
        "
        type="number"
        min="1"
        max="9999"
        minlength="1"
        maxlength="4"
        placeholder="Price"
      />
    </div>

    <div class="col-auto p-0">
      <input
        class="
          form-control
          stock-input
          border-input
          not-required
          variation-stock
        "
        type="number"
        min="1"
        max="9999"
        minlength="1"
        maxlength="4"
        placeholder="Stock"
      />
    </div>

    <div class="col-auto p-2 my-auto">
      <i class="fa-solid fa-trash-can" onclick="deleteVariation(${id})"></i>
    </div>
  `;

  target.append(append);

  enableSubmitBtn();
};

window.toggleVariations = function toggleVariations(event) {
  const variations = document.querySelector('#variationList');
  const addVariation = document.querySelector('#addVariation');

  if (event.target.checked) {
    variations.innerHTML = ``;
  }

  variations.classList.toggle('tph-disabled');
  addVariation.classList.toggle('tph-disabled');
};

window.deleteVariation = function deleteVariation(variationID) {
  const modal = new bootstrap.Modal(variationRemove);
  const footer = document
    .querySelector('#variationRemove')
    .querySelector('.modal-footer');
  modal.show();

  footer.innerHTML = `
    <button id="delete" type="button" class="btn btn-highlight" onclick="removeProductVariation(${variationID})">
      Delete
    </button>
    <button
      id="cancel"
      type="button"
      class="btn modal-cancel-btn remove-product"
      data-bs-dismiss="modal"
      onclick="dismissModal(variationRemove)"
    >
      Cancel
    </button>
  `;
};

window.dismissModal = function dismissModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  modal.hide();
};

window.removeProductVariation = async function removeProductVariation(
  variationID
) {
  console.log(variationID);

  const success = JSON.parse(await deleteVariation(variationID));

  if (success) {
    dismissModal(variationRemove);
    const modal = new StatusModal('Removed!');
    modal.show();
    modal.dismissAfter(500);
    document.querySelector(`#v${variationID}`).remove();
  }
};

window.attemptEditListing = async function attemptEditListing(event) {
  noSubmit(event);

  let variationIDs = Array.from(
    document.querySelectorAll('.variation-row')
  ).map((r) => parseInt(r.id.slice(1)));

  let variationName = Array.from(
    document.querySelectorAll('.variation-name')
  ).map((i) => i.value);
  let variationStock = Array.from(
    document.querySelectorAll('.variation-stock')
  ).map((i) => parseInt(i.value));
  let variationPrice = Array.from(
    document.querySelectorAll('.variation-price')
  ).map((i) => parseInt(i.value));

  const variations = variationName.map((i, idx) => {
    return {
      name: i,
      price: variationPrice[idx],
      stock: variationStock[idx],
      id: variationIDs[idx],
    };
  });

  const oldVariations = variations.filter((v) =>
    LISTING.product_variations.find((e) => e.variation_id == v.id)
  );

  const newVariations = variations.filter(
    (v) =>
      LISTING.product_variations.find((e) => e.variation_id == v.id) ==
      undefined
  );

  const listing = {
    listingID: parseInt(new URLSearchParams(window.location.search).get('id')),
    listingImg:
      document.querySelector('#listingImg').files.length > 0
        ? '/tindahan.ph/assets/mock/products/' +
          document.querySelector('#listingImg').files[0].name
        : LISTING.product_img,
    listingName: document.querySelector('#listingName').value,
    listingPrice: parseInt(document.querySelector('#listingPrice').value),
    listingDesc: document.querySelector('#shdesc').value,
    listingCateg: parseInt(document.querySelector('#listingCategory').value),
    listingQuantity: parseInt(document.querySelector('#listingStock').value),
    listingBrand: document.querySelector('#listingBrand').value,
    listingOldVariations: oldVariations,
    listingNewVariations: newVariations,
  };

  console.log(listing);

  const success = await updateListingDetails(listing);

  console.log(success);

  if (success) {
    const modal = new StatusModal('Listing updated!');
    modal.show();
    window.history.back();
  }
};
