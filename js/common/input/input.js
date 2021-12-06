// Attach a character count listener to a textarea
// WHEN: Call this function when there's a textarea that needs to be watched.
// PARAMS: id of textarea | id of char counter div/span | max char count
export function attachCharCountListener(listeningTo, countField) {
  listeningTo.addEventListener('input', () => {
    let charCount = listeningTo.value.length;

    countField.innerText = charCount;
  });
}

// Returns true if all input elements are NOT empty
// PARAMS: Array of input elements of type HTMLElement
export function inputIsEmpty(input) {
  return input.value.length === 0 ? true : false;
}

export function fileHasNotBeenUploaded(upload) {
  const limit = document.querySelector('#fileLimit');

  return upload.files.length == 0 ? true : false;
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
    case 'name':
      error = isValidAlphabetic(input.value) ? '' : 'alpha';
      break;
    case 'email':
      error = isValidEmail(input.value) ? '' : 'email';
      break;
    case 'number':
      error = isValidNumber(input)
        ? isWithinMinNumberCount(input)
          ? isWithinMaxNumberCount(input)
            ? ''
            : 'numexceed'
          : 'numbelow'
        : 'number';
      break;
    case 'password':
      error = isMatchingPasswords(input) ? '' : 'passmatch';
      break;
  }

  return error;
}

// Checks if the given textarea's text length is within the maximum
// character count specified. Note that the maximum count is not a parameter,
// rather it is being searched within the DOM. Please wrap your textarea
// inside a div with class="form-textarea", and attach a div with class
// ="character-count-area" with three span children.
// The first span child is the initial char count (0) and must have a unique
// id in this format: modalIDMsgCount. The second span is just the /, while
// the third span is the actual maximum character count; it must have a class
// of "charLimit".
// WHEN: When you want to validate a textarea's character length.
// PARAMS: event (submit event)
export function isWithinMaxCharCount(text) {
  const limit = text.parentElement.querySelector('.charLimit').innerText;

  return text.value.length <= limit ? '' : 'textover';
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

  number = number.value.toString();

  return regExp.test(number);
}

function isWithinMinNumberCount(number) {
  const min = number.getAttribute('minlength');

  number = number.value.toString();

  return number.length >= min ? true : false;
}

function isWithinMaxNumberCount(number) {
  const limit = number.getAttribute('maxlength');

  number = number.value.toString();

  return number.length <= limit ? true : false;
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

  if (!parent.classList.contains('for-validation')) {
    return;
  }

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
      case 'textover':
        errorMsg = 'Please limit your message to the maximum character count.';
        break;
      case 'number':
        errorMsg = 'No letters allowed. Please enter numbers only.';
        break;
      case 'numexceed':
        errorMsg = `Please don't exceed the max allowed digits.`;
        break;
      case 'numbelow':
        errorMsg = `The number does not meet length requirement.`;
        break;
    }

    elem.classList.remove('is-valid');
    elem.classList.add('is-invalid');
    errorElem.classList.add('invalid-feedback');
    errorElem.innerText = errorMsg;
    parent.append(errorElem);
  } else {
    elem.classList.remove('is-invalid');
    elem.classList.contains('no-success') ? '' : elem.classList.add('is-valid');
  }
}
