// Checks the database to see if user with given credentials exists.
// WHEN: Call this function during logging in / signing up.
// PARAMS: User object that has email and password members.
export function validateIfExists(user) {
  return new Promise(function (resolve, reject) {
    $.ajax({
      type: 'GET',
      url: '/tindahan.ph/php/auth.php',
      data: {
        type: 'probe',
        email: user.email,
        password: user.password,
      },
      success: (result) => {
        result = JSON.parse(result);

        if (result) {
          resolve(result);
        } else {
          reject(result);
        }
      },
    });
  });
}

export function redirectUser(utype) {
  window.setTimeout(() => {
    window.location.href =
      utype == 'admin'
        ? '/tindahan.ph/index.php?u=admin'
        : utype === 'partner'
        ? '/tindahan.ph/index.php?u=partner'
        : '/tindahan.ph/index.php?u=user';
  }, 1000);
}

// TODO Convert to custom error (modal)
export function userAlreadyExists() {
  alert('User already exists.');
}

// TODO Convert to custom error (modal)
export function userDoesNotExist() {
  alert('Error! That email is not associated with any account.');
}
