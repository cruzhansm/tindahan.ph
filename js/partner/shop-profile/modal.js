import {
  noSubmit,
  disableSubmitBtn,
  attachEmptyFieldListeners,
  resetFlags,
  stripInputListeners,
  removeAllValidation,
} from '../../common/input/form.js';

import { updatePartnerStoreDetails } from '../db-methods/update.js';

import { attachCharCountListener } from '../../common/input/input.js';
import { initializeModalData, STORE } from './shop-profile.js';

window.showModal = function showModal(selectedModal) {
  const modal = new bootstrap.Modal(selectedModal);
  const form = selectedModal.querySelector('form');

  modal.show();

  initializeModalData(STORE);

  disableSubmitBtn(form)
    .then(attachEmptyFieldListeners('input'))
    .then(attachEmptyFieldListeners('file'))
    .then(attachEmptyFieldListeners('textarea'))
    .then(attachEmptyFieldListeners('number'))
    .then(
      attachCharCountListener(
        form.querySelector(`#${selectedModal.id}Msg`),
        form.querySelector(`#${selectedModal.id}MsgCount`)
      )
    )
    .catch((reject) => {
      console.log(reject);
    });
};

window.dismissModal = function dismissModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const form = selectedModal.querySelector('form');

  resetFlags().then(stripInputListeners(form)).then(removeAllValidation(form));

  modal.hide();
};

window.attemptEditProfile = function attemptEditProfile(event) {
  noSubmit(event);

  if (
    event.target
      .querySelector('button[type=submit]')
      .classList.contains('tph-disabled')
  ) {
    return;
  }

  const address =
    document.querySelector('#partnerBarangay').value +
    ', ' +
    document.querySelector('#partnerCity').value;

  let img = null;

  try {
    img = `/tindahan.ph/assets/mock/partner/${
      document.querySelector('#partnerImg').files[0].name
    }`;
  } catch (err) {
    console.log('No new image uploaded.');
  }

  const editDetails = {
    storeImg: img == null ? STORE.store_img : img,
    storeName: document.querySelector('#partnerName').value,
    storeDesc: document.querySelector('#editProfileMsg').value,
    storeAddress: address,
    storeContact: parseInt(document.querySelector('#partnerContact').value),
  };

  console.log(editDetails);

  dismissModal(editProfile);
  updatePartnerStoreDetails(editDetails);
};
