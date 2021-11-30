// TODO
// 3. Validate data using validation.js (await backend)
// 4. AJAX call to verify credentials (await backend)
// 5. If verified, redirect; else, throw error (implemented)

import { noSubmit } from '../input/form.js';
import {
  redirectUser,
  userDoesNotExist,
  validateIfExists,
} from '../input/validation.js';

// CHECK WHICH MODE AND DISPLAY APPROPRIATE FORM
window.onload = () => {
  const loginForm = document.querySelector('#login-box');
  const signupForm = document.querySelector('#signup-box');

  if (new URLSearchParams(window.location.search).get('mode') === 'signup') {
    loginForm.classList.add('visually-hidden');
    signupForm.classList.remove('visually-hidden');
  } else {
    const url = new URL(window.location.href);

    url.searchParams.set('mode', 'login');
    window.history.pushState({ path: url.href }, ' ', url.href);
    loginForm.classList.remove('visually-hidden');
    signupForm.classList.add('visually-hidden');
  }
};

// GATHER FORM DATA AND VALIDATE
window.attemptLogin = async function attemptLogin(event) {
  noSubmit(event);

  const form = event.target;

  const user = {
    email: form.querySelector('input[type=email]').value,
    password: form.querySelector('input[type=password]').value,
  };

  validateIfExists(user).then(login(user)).catch(userDoesNotExist);
};

function login(user) {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/auth.php',
    data: {
      type: 'login',
      email: user.email,
      password: user.password,
    },
    success: (result) => {
      result = JSON.parse(result);

      result !== null && typeof result === 'string'
        ? redirectUser(result)
        : alert(`${result.error_msg}`);
    },
  });
}
