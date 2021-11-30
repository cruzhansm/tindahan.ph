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
export function validateIfPasswordsMatch(password, confirm) {
  return password.localeCompare(confirm) === 0 ? true : false;
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

export function userAlreadyExists() {
  alert('User already exists.');
}

export function userDoesNotExist() {
  alert(
    `User does not exist. Please check your email or password and try again.`
  );
}
