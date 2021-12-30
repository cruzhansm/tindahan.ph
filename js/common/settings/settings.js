import {
  validateSettings,
  initializeInfoSettings,
} from '/tindahan.ph/js/common/db-methods/retrieve.js';
import {
  noSubmit,
  disableSubmitBtn,
  attachEmptyFieldListeners,
  resetFlags,
  stripInputListeners,
  removeAllValidation,
} from '/tindahan.ph/js/common/input/form.js';
import {
  updateUserInfo,
  updateEmail,
  updatePassword,
} from '/tindahan.ph/js/common/db-methods/update.js';
import { fetchUserDetails } from '/tindahan.ph/js/common/db-methods/retrieve.js';

var USER_DETAILS = new Object();

window.showModal = function showModal(selectedModal) {
  const modal = new bootstrap.Modal(selectedModal);
  modal.show();
};

window.dismissModal = function dismissModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const form = selectedModal.querySelector('form');

  resetFlags().then(stripInputListeners(form)).then(removeAllValidation(form));

  modal.hide();
};

window.dismissSettingsModal = function dismissSettingsModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);
  const newEmail = document.getElementById('newEmail');
  const newPassword = document.getElementById('newPassword');
  const info = document.getElementById('infoSettings');
  const account = document.querySelector('.active-form');

  console.log(account);
  if (account != null) {
    const accountForm = account.querySelector('form');
    resetFlags()
      .then(stripInputListeners(accountForm))
      .then(removeAllValidation(accountForm));
    account.classList.remove('active-form');
  }

  const infoForm = info.querySelector('form');
  resetFlags()
    .then(stripInputListeners(infoForm))
    .then(removeAllValidation(infoForm));

  newEmail.classList.add('visually-hidden');
  newPassword.classList.add('visually-hidden');
  document.getElementById('accountData').classList.remove('visually-hidden');

  modal.hide();
};

window.showSettings = function showSettings(selectedModal) {
  fetchUserDetails().then((data) => {
    USER_DETAILS = data;
  });

  const modal = new bootstrap.Modal(selectedModal);
  const form = selectedModal.querySelector('form');

  modal.show();

  const verifyForm = document.querySelector('#verify-settings');
  disableSubmitBtn(verifyForm).then(attachEmptyFieldListeners('input'));
};

window.attemptAccessSettings = async function attemptAccessSettings(event) {
  noSubmit(event);
  const userPass = document.querySelector('#verify-settings-input').value;

  if (
    event.target
      .querySelector('button[type=submit]')
      .classList.contains('tph-disabled')
  ) {
    return;
  }

  const correctPass = JSON.parse(await validateSettings(userPass));

  if (correctPass) {
    dismissModal(verifySettings);
    showSettingsModal(settingsModal);
  } else {
    alert('Incorrect password.');
  }
};

window.showSettingsModal = async function showSettingsModal(selectedModal) {
  const modal = new bootstrap.Modal(selectedModal);
  const form = selectedModal.querySelector('form');
  modal.show();

  const info = JSON.parse(await initializeInfoSettings());

  const city = document.getElementById('user-city');
  const barangay = document.getElementById('user-barangay');
  const street = document.getElementById('user-street');
  const zipcode = document.getElementById('user-zipcode');
  const landmark = document.getElementById('user-landmark');
  const phone = document.getElementById('user-contact');
  const email = document.getElementById('accountUserEmail');

  document.getElementById('previewImg').setAttribute('src', info.image);
  document.getElementById('user-fName').value = info.fname;
  document.getElementById('user-lName').value = info.lname;
  info.city == null || info.city == ''
    ? (city.placeholder = 'Not yet set')
    : (city.value = info.city);
  info.barangay == null || info.barangay == ''
    ? (barangay.placeholder = 'Not yet set')
    : (barangay.value = info.barangay);
  info.street == null || info.street == ''
    ? (street.placeholder = 'Not yet set')
    : (street.value = info.street);
  info.zipcode == null || info.zipcode == ''
    ? (zipcode.placeholder = 'Not yet set')
    : (zipcode.value = info.zipcode);
  info.landmark == null || info.landmark == ''
    ? (landmark.placeholder = 'Not yet set')
    : (landmark.value = info.landmark);
  info.phone == null || info.phone == 0
    ? (phone.placeholder = 'Not yet set')
    : (phone.value = info.phone);

  email.innerHTML = `${info.email}`;

  console.log(form);

  if (info != null) {
    disableSubmitBtn(form)
      .then(attachEmptyFieldListeners('input'))
      .then(attachEmptyFieldListeners('file'))
      .then(attachEmptyFieldListeners('number'))
      .catch((reject) => {
        console.log(reject);
      });
  }
};

window.attemptUpdateInfo = function attemptUpdateInfo(event) {
  noSubmit(event);

  if (
    event.target
      .querySelector('button[type=submit]')
      .classList.contains('tph-disabled')
  ) {
    return;
  }

  let img = null;

  try {
    img = `/tindahan.ph/assets/mock/users/${
      document.querySelector('#partnerImg').files[0].name
    }`;
  } catch (err) {
    console.log('No new image uploaded.');
  }

  const updateInfo = {
    userImg: img == null ? USER_DETAILS.image : img,
    userfName: document.getElementById('user-fName').value,
    userlName: document.getElementById('user-lName').value,
    userCity: document.getElementById('user-city').value,
    userBarangay: document.getElementById('user-barangay').value,
    userStreet: document.getElementById('user-street').value,
    userZipcode: document.getElementById('user-zipcode').value,
    userLandmark: document.getElementById('user-landmark').value,
    userPhone: document.getElementById('user-contact').value,
  };

  dismissSettingsModal(settingsModal);
  updateUserInfo(updateInfo);
};

window.openInfo = function openInfo() {
  const info = document.getElementById('infoSettings');
  const account = document.querySelector('.active-form');
  const newEmail = document.getElementById('newEmail');
  const newPassword = document.getElementById('newPassword');

  if (account != null) {
    const accountForm = account.querySelector('form');
    resetFlags()
      .then(stripInputListeners(accountForm))
      .then(removeAllValidation(accountForm));
    account.classList.remove('active-form');
  }

  newEmail.classList.add('visually-hidden');
  newPassword.classList.add('visually-hidden');
  document.getElementById('accountData').classList.remove('visually-hidden');

  initializeInfoSettings();

  const infoForm = info.querySelector('form');
  disableSubmitBtn(infoForm)
    .then(attachEmptyFieldListeners('input'))
    .then(attachEmptyFieldListeners('file'))
    .then(attachEmptyFieldListeners('number'))
    .catch((reject) => {
      console.log(reject);
    });
};

window.openAccount = function openAccount() {
  const info = document.getElementById('infoSettings');
  const infoForm = info.querySelector('form');
  resetFlags()
    .then(stripInputListeners(infoForm))
    .then(removeAllValidation(infoForm));

  document.getElementById('accountData').classList.toggle('active-form');
};

window.changeEmail = function changeEmail() {
  const emailTab = document.getElementById('newEmail');
  const dataTab = document.getElementById('accountData');

  dataTab.classList.add('visually-hidden');
  dataTab.classList.remove('active-form');

  emailTab.classList.remove('visually-hidden');
  emailTab.classList.add('active-form');

  const form = emailTab.querySelector('form');
  disableSubmitBtn(form)
    .then(attachEmptyFieldListeners('input'))
    .catch((reject) => {
      console.log(reject);
    });
};

window.attemptUpdateEmail = function attemptUpdateEmail(event) {
  noSubmit(event);

  if (
    event.target
      .querySelector('button[type=submit]')
      .classList.contains('tph-disabled')
  ) {
    return;
  }

  const email = document.getElementById('inputNewEmail').value;

  dismissSettingsModal(settingsModal);
  updateEmail(email);
};

window.changePassword = function changePassword() {
  const dataTab = document.getElementById('accountData');
  const passTab = document.getElementById('newPassword');

  dataTab.classList.add('visually-hidden');
  dataTab.classList.remove('active-form');

  passTab.classList.remove('visually-hidden');
  passTab.classList.add('active-form');

  const form = passTab.querySelector('form');
  console.log(form);
  disableSubmitBtn(form)
    .then(attachEmptyFieldListeners('input'))
    .catch((reject) => {
      console.log(reject);
    });
};

window.attemptUpdatePassword = function attemptUpdatePassword(event) {
  noSubmit(event);

  if (
    event.target
      .querySelector('button[type=submit]')
      .classList.contains('tph-disabled')
  ) {
    return;
  }

  const password = document.getElementById('updatePassword').value;

  dismissSettingsModal(settingsModal);
  updatePassword(password);
};
