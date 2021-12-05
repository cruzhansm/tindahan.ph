import { attachCharCountListener } from '../common/input/input.js';
import {
  noSubmit,
  disableSubmitBtn,
  attachEmptyFieldListeners,
  resetFlags,
  stripInputListeners,
  removeAllValidation,
} from '../common/input/form.js';
import { insertPartnerApplication } from './db-methods/insert.js';
import { userHasApplied } from './db-methods/retrieve.js';

window.onload = () => {
  userHasApplied().then((resolve) => {
    if (resolve) {
      const show = document.querySelector('.register-process');

      show.classList.remove('visually-hidden');
      show.style.marginBottom = '350px';
    } else {
      const show = document.querySelector('.register-prompt');
      show.classList.remove('visually-hidden');
    }
  });
};

window.showRegisterForm = function showRegisterForm() {
  const registerPrompt = document.querySelector('.register-prompt');
  const registerForm = document.querySelector('.register-form');
  const containerDisplay = document.querySelector('.container-display');
  const header = document.querySelector('.header');
  const right = document.querySelector('.right');

  containerDisplay.style.marginBottom = '33px';
  header.style.marginBottom = '33px';
  right.style.marginBottom = '90px';
  registerPrompt.classList.toggle('visually-hidden');
  registerForm.classList.toggle('visually-hidden');

  const form = registerForm.querySelector('form');
  const textarea = form.querySelector('textarea');
  const charCount = textarea.parentElement.querySelector('.character-count');

  disableSubmitBtn(form)
    .then(attachEmptyFieldListeners('input'))
    .then(attachEmptyFieldListeners('textarea'))
    .then(attachEmptyFieldListeners('file'))
    .then(attachCharCountListener(textarea, charCount))
    .then(attachOnlineSellingListener())
    .catch((reject) => {
      console.log('Boohoo');
    });
};

window.attemptPartnerRegistration = function attemptPartnerRegistration(e) {
  noSubmit(e);

  const form = document.querySelector('.register-form').querySelector('form');

  const application = {
    storeName: form.querySelector('#storeName').value,
    storeCategory: form.querySelector('#categ').value,
    storeExperience: form.querySelector('input[type=radio]:checked').value,
    storePlatforms: form.querySelector('#platforms').value,
    storeDesc: form.querySelector('#shdesc').value,
    storeImg: Array.from(form.querySelector('input[type=file]').files)[0],
  };

  resetFlags().then(stripInputListeners(form)).then(removeAllValidation(form));

  insertPartnerApplication(application);
  setTimeout(() => proceedToReview(), 1000);
};

window.proceedToReview = function proceedToReview() {
  const registerForm = document.querySelector('.register-form');
  const registerReview = document.querySelector('.register-process');
  const right = document.querySelector('.right');

  right.style.marginBottom = '430px';
  registerForm.classList.toggle('visually-hidden');
  registerReview.classList.toggle('visually-hidden');
};

window.attachOnlineSellingListener = function attachOnlineSellingListener() {
  const radios = document.querySelectorAll('input[type=radio]');
  const onlineSelling = document.querySelector('.for-validation.disabled');

  Array.from(radios).forEach((radio) => {
    radio.addEventListener('change', () => {
      const checked = document.querySelector('input[type=radio]:checked');

      if (checked.id.localeCompare('noNewSell') == 0) {
        onlineSelling.classList.remove('disabled');
      } else {
        onlineSelling.classList.add('disabled');
        onlineSelling.querySelector('#platforms').value = '';
      }
    });
  });
};
