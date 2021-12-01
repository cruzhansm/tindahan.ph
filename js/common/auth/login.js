// Import specific functions from specific .js file prefixed with export
// You must set add type=module to the script when importing in .php file
// because you used imports.
import {
  noSubmit,
  disableSubmitBtn,
  attachEmptyFieldListeners,
} from '../input/form.js';
import {
  redirectUser,
  userDoesNotExist,
  validateIfExists,
} from '../input/validation.js';

// Checks the current URL; If no mode set, automatically redirects to
// mode=login. If user chooses to login/signup, changes URL to match action
// and redirect them. Aside from that, automatically disables submit button
// of the current page's form.
window.onload = () => {
  const loginForm = document.querySelector('#login-box');
  const signupForm = document.querySelector('#signup-box');
  let currentForm;

  if (new URLSearchParams(window.location.search).get('mode') === 'signup') {
    currentForm = signupForm;

    loginForm.classList.add('visually-hidden');
    signupForm.classList.remove('visually-hidden');
  } else {
    const url = new URL(window.location.href);

    url.searchParams.set('mode', 'login');
    window.history.pushState({ path: url.href }, ' ', url.href);
    loginForm.classList.remove('visually-hidden');
    signupForm.classList.add('visually-hidden');

    currentForm = loginForm;
  }

  disableSubmitBtn(currentForm)
    .then(attachEmptyFieldListeners('input'))
    .catch((reject) => {
      console.log(reject);
    });
};

// Attempts to login user by checking if user exists; If exists, logs them in
// If user doesn't exist, throw error.
// PARAMS: The current event being handled (submit event)
window.attemptLogin = async function attemptLogin(event) {
  noSubmit(event);

  const form = event.target;

  const user = {
    email: form.querySelector('input[type=email]').value,
    password: form.querySelector('input[type=password]').value,
  };

  validateIfExists(user)
    .then((resolve) => login(user, resolve))
    .catch((reject) => userDoesNotExist(reject));
};

// Checks if BOTH email and password entered matches record
// If match, redirect the user to their home page, else throw error.
// PARAMS: User object containing email and password | Promise.resolve()
function login(user, found) {
  if (found) {
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
}
