window.onload = () => {
  let accountVerify = document.getElementById('account-verify');
  let accountData = document.getElementById('account-data');
  let accountReverifyPassword = document.getElementById('account-reverify-password');
  let accountReverifyEmail = document.getElementById('account-reverify-email');
  let accountEmail = document.getElementById('account-new-email');
  let accountPassword = document.getElementById('account-new-password');

  document.getElementById('account-tab').addEventListener('click', () => {
    accountVerify.classList.remove('visually-hidden');
    accountData.classList.add('visually-hidden');
    accountReverifyPassword.classList.add('visually-hidden');
    accountReverifyEmail.classList.add('visually-hidden');
    accountPassword.classList.add('visually-hidden');
    accountEmail.classList.add('visually-hidden');
  });

  document.getElementById('account-data-switch').addEventListener('click', () => {
    accountVerify.classList.toggle('visually-hidden');
    accountData.classList.toggle('visually-hidden');
  });

  document.getElementById('account-reverify-email-switch').addEventListener('click', () => {
    accountReverifyEmail.classList.toggle('visually-hidden');
    accountData.classList.toggle('visually-hidden');
  });

  document.getElementById('account-reverify-password-switch').addEventListener('click', () => {
    accountReverifyPassword.classList.toggle('visually-hidden');
    accountData.classList.toggle('visually-hidden');
  });

  document.getElementById('account-update-password-switch').addEventListener('click', () => {
    accountReverifyPassword.classList.toggle('visually-hidden');
    accountPassword.classList.toggle('visually-hidden');
  });

  document.getElementById('account-update-email-switch').addEventListener('click', () => {
    accountReverifyEmail.classList.toggle('visually-hidden');
    accountEmail.classList.toggle('visually-hidden');
  });
  
  document.getElementById('account-new-password-switch').addEventListener('click', () => {
    accountPassword.classList.toggle('visually-hidden');
    accountData.classList.toggle('visually-hidden');
  });

  document.getElementById('account-new-email-switch').addEventListener('click', () => {
    accountEmail.classList.toggle('visually-hidden');
    accountData.classList.toggle('visually-hidden');
  });
}

function updateProfile() {
  alert("Hello World!");
}
