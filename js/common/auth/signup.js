import { noSubmit } from '../input/form.js';
import { validateIfExists } from '../input/validation.js';
import { userAlreadyExists } from '../input/validation.js';

// Attempts to register new account by checking if user exists; If exists,
// throw error (exists = email is found in database); else, redirect to login.
// PARAMS: The current event being handled (submit event)
window.attemptSignup = function attemptSignup(event) {
  noSubmit(event);

  const form = event.target;

  const user = {
    email: form.querySelector('input[type=email]').value,
    fname: form.querySelector('#fname').value,
    lname: form.querySelector('#lname').value,
    password: form.querySelector('#password').value,
    cpassword: form.querySelector('#cpassword').value,
  };

  validateIfExists(user)
    .then(userAlreadyExists)
    .catch((error) => createNewUser(user, error));
};

function createNewUser(user, notFound) {
  if (notFound == false) {
    $.ajax({
      type: 'POST',
      url: '/tindahan.ph/php/auth.php',
      data: {
        type: 'signup',
        email: user.email,
        password: user.password,
        fname: user.fname,
        lname: user.lname,
      },
      success: (result) => {
        result = JSON.parse(result);

        if (typeof result === 'string') {
          redirectToLogin();
        } else {
          alert(`${result.error}! \n${result.error_msg}`);
        }
      },
    });
  }
}

function redirectToLogin() {
  window.location.href = '/tindahan.ph/src/common/login.php?mode=login';
}
