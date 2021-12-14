import {
  disableSubmitBtn,
  attachEmptyFieldListeners,
  noSubmit,
} from '../../common/input/form.js';
import { attachCharCountListener } from '../../common/input/input.js';
import { insertListingApplication } from '../db-methods/insert.js';
import { StatusModal } from '../../common/modal/status-modal.js';

window.onload = async () => {
  const form = document.querySelector('form');

  disableSubmitBtn(form)
    .then(attachEmptyFieldListeners('file'))
    .then(attachEmptyFieldListeners('input'))
    .then(attachEmptyFieldListeners('textarea'))
    .then(attachCharCountListener(shdesc, shdescMsgCount));
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

window.addNewVariation = function addNewVariation() {
  const target = document.querySelector('#variationList');
  const append = document.createElement('div');
  let id = document.querySelectorAll('.variation-row').length;
  append.classList.add('row', 'variation-row');
  append.setAttribute(`id`, `v${id}`);

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
};

window.attemptNewListing = async function attemptNewListing(event) {
  noSubmit(event);

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
    return { name: i, price: variationPrice[idx], stock: variationStock[idx] };
  });

  const listing = {
    listingImg:
      '/tindahan.ph/assets/mock/products/' +
      document.querySelector('#listingImg').files[0].name,
    listingName: document.querySelector('#listingName').value,
    listingPrice: parseInt(document.querySelector('#listingPrice').value),
    listingDesc: document.querySelector('#shdesc').value,
    listingCateg: parseInt(document.querySelector('#listingCategory').value),
    listingQuantity: parseInt(document.querySelector('#listingStock').value),
    listingBrand: document.querySelector('#listingBrand').value,
    listingVariations: variations,
  };

  console.log(listing);

  const success = JSON.parse(await insertListingApplication(listing));

  if (success) {
    const modal = new StatusModal('Application sent!');
    modal.show();
    window.location.reload();
  }
};

window.deleteVariation = function deleteVariation(variationID) {
  document.querySelector(`#v${variationID}`).remove();
};
