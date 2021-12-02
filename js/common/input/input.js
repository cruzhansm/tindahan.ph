// Attach a character count listener to a textarea
// WHEN: Call this function when there's a textarea that needs to be watched.
// PARAMS: id of textarea | id of char counter div/span | max char count
function attachCharCountListener(listeningTo, countField, maxChar) {
  listeningTo.addEventListener('input', () => {
    let charCount = listeningTo.value.length;

    if (charCount <= maxChar) {
      countField.innerText = charCount;
    }
  });
}

// Returns true if all input elements are NOT empty
// PARAMS: Array of input elements of type HTMLElement
export function inputIsEmpty(input) {
  return input.value.length === 0 ? true : false;
}

// Returns true if at least one checkbox is checked
// PARAMS: Array of checkbox elements of type HTMLElement
export function checkboxesNotSelcted(checkboxes) {
  return checkboxes.some((checkbox) => checkbox.checked) ? true : false;
}

// Returns true if at least one radio is checked
// PARAMS: Array of radio elements of type HTMLElement
export function radiosNotSelected(radios) {
  return radios.some((radio) => radio.checked) ? true : false;
}

// Returns true if at least one select > option is selected
// PARAMS: Array of select elements of type HTMLElement
export function selectNotSelected(select) {
  return select.value == '' ? true : false;
}

// Identifies the input[type=?] of the given input and calls validating
// functions depending on the type of input.
// WHEN: Call this function if you need to verify multiple input elements.
// PARAMS: Input element to be validated
export function isCorrectFormat(input) {
  const type = input.type;
  let error = new String();

  switch (type) {
    case 'text':
      error = isValidAlphabetic(input.value) ? '' : 'alpha';
      break;
    case 'email':
      error = isValidEmail(input.value) ? '' : 'email';
      break;
    case 'number':
      error = isValidNumber(input.value) ? '' : 'numner';
      break;
    case 'password':
      error = isMatchingPasswords(input) ? '' : 'passmatch';
      break;
  }

  return error;
}

function isValidAlphabetic(input) {
  const regExp = /^[a-zA-Z\s]*$/;
  return regExp.test(input);
}

function isValidEmail(email) {
  const regExp = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  return regExp.test(email);
}

function isValidNumber(number) {
  const regExp = /^[0-9]+$/;
  number = typeof number === 'string' ? number : number.toString();
  return regExp.test(number);
}

export function passwordMismatchError(password) {
  const passwords =
    password.parentElement.parentElement.querySelectorAll('.form-password');

  setTimeout(() => {
    updateInputState(passwords[0], true, 'passmatch');
    updateInputState(passwords[1], true, 'passmatch');
  }, 100);
}

function removePasswordMismatchErrors(password, password2) {
  setTimeout(() => {
    updateInputState(password, false, 'passmatch');
    updateInputState(password2, false, 'passmatch');
  }, 100);
}

export function isMatchingPasswords(password) {
  const passwords =
    password.parentElement.parentElement.querySelectorAll('.form-password');

  if (passwords[1] == password && passwords.length == 2) {
    if (password.value.localeCompare(passwords[0].value) === 0) {
      removePasswordMismatchErrors(password, passwords[0]);
      return true;
    } else {
      return false;
    }
  } else if (passwords[0] == password && passwords.length == 2) {
    if (password.value.localeCompare(passwords[1].value) === 0) {
      removePasswordMismatchErrors(password, passwords[1]);
      return true;
    } else {
      return false;
    }
  } else if (passwords.length == 1) {
    return true;
  }
}

// If state is true (invalid input), then indentifies what input type
// is invalid (check) and generates an invalid error with a message
// corresponding to the invalid input type.
// WHEN: Call this function when you need to update valid/invalid messages.
// PARAMS: The element to append / remove error | The validation operation
// performed | Boolean (true = add, false = remove)
export function updateInputState(elem, state, check) {
  const parent = elem.parentElement;
  const error = parent.querySelector('.invalid-feedback');

  error != null ? error.remove() : '';

  if (state) {
    let errorMsg = new String();
    const errorElem = document.createElement('div');

    switch (check) {
      case 'empty':
        errorMsg = 'Empty field.';
        break;
      case 'email':
        errorMsg = 'Please enter a valid email address.';
        break;
      case 'alpha':
        errorMsg = 'Only letters are allowed.';
        break;
      case 'passmatch':
        errorMsg = 'Passwords do not match.';
        break;
    }

    elem.classList.remove('is-valid');
    elem.classList.add('is-invalid');
    errorElem.classList.add('invalid-feedback');
    errorElem.innerText = errorMsg;
    parent.append(errorElem);
  } else {
    elem.classList.remove('is-invalid');
    elem.classList.add('is-valid');
  }
}
