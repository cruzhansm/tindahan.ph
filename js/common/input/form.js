import {
  inputIsEmpty,
  checkboxesNotSelcted,
  radiosNotSelected,
  selectNotSelected,
  fileHasNotBeenUploaded,
  updateInputState,
  passwordMismatchError,
  isCorrectFormat,
  isWithinMaxCharCount,
} from './input.js';

var SELECTED_FORM; // Current form being evaluated
var FORM_HAS_EMPTY = true; // Determines if current form has empty fields
var FORM_HAS_INVALID = true; // Determines if current form has invalid inputs
var FORM_HAS_REQUIRED = true;
var FORM_INPUTS = [];

// Prevent form submission, used for AJAX requests
// WHEN: Call this during form submission / clicking of submit button
// PARAMS: current event (simply pass event)
export function noSubmit(event) {
  event.preventDefault();
}

// Resets the input validation state to untracked / not validating anything
// WHEN: Use this when closing a modal, or switching between different forms
// (call this function, then make the other form appear and init validation).
// PARAMS: none
export function resetFlags() {
  // console.log(SELECTED_FORM, FORM_HAS_EMPTY, FORM_HAS_INVALID, FORM_HAS_REQUIRED, FORM_INPUTS);
  SELECTED_FORM = null;
  FORM_HAS_EMPTY = FORM_HAS_INVALID = true;
  FORM_INPUTS = [];

  return Promise.resolve();
}

// Strips / disables the attached input validation event listeners to the
// form that is discarded / hidden from view.
// WHEN: Call this function in conjunction with resetFlags() to ensure
// that when switching between different forms or dismissing a form,
// it is not being validated anymore. This will prevent conflicts in the case
// that you want to validate another form.
// PARAMS: The form of type HTMLFormElement which you want to discard
export function stripInputListeners(form) {
  const inputs = Array.from(form.elements);

  inputs.forEach((input) => {
    input.removeEventListener('input', attachEmptyFieldListeners, true);
  });

  form.reset();
}

// Removes all the valid/invalid styling for all inputs in the form.
// WHEN: Call this function when you dismiss a form or switch to another form
// or finish using that form.
// PARAMS: The form you wish to discard.
export function removeAllValidation(form) {
  const validInputs = form.querySelectorAll('.is-valid');
  const invalidInputs = form.querySelectorAll('.is-invalid');
  const customErrors = form.querySelectorAll('.invalid-feedback');

  validInputs.forEach((input) => input.classList.remove('is-valid'));
  invalidInputs.forEach((input) => input.classList.remove('is-invalid'));
  customErrors.forEach((error) => (error.innerText = ''));
}

// Disables the submit button of form when one or more fields are empty
// WHEN: Call this function on window.onload of page that contains a form
// PARAMS: the form itself (typeof HTMLElement)
export function disableSubmitBtn(form) {
  form = form || SELECTED_FORM;
  const submit = form.querySelector('button[type=submit]');

  const forValidation = form.querySelectorAll('.for-validation');

  SELECTED_FORM = form;

  FORM_HAS_REQUIRED = form.classList.contains('not-required') ? false : true;

  if (!submit.classList.contains('tph-disabled')) {
    submit.classList.add('tph-disabled'); // css/components/button.css
  }

  return form == undefined || submit == undefined || forValidation.length == 0
    ? Promise.reject('Nothing to validate.')
    : Promise.resolve();
}

function enableSubmitBtn() {
  const submit = SELECTED_FORM.querySelector('button[type=submit]');

  if (submit.classList.contains('tph-disabled')) {
    submit.classList.remove('tph-disabled');
  }
}

// Attaches eventListeners to parameter 'watch' elements, checks if the
// elements being watched are empty and sets FORM_HAS_EMPTY flag true
// if none of the watched elements are empty
// WHEN: Call this function after disableSubmitBtn()
// PARAMS: HTML tag of element to wat
export function attachEmptyFieldListeners(watch) {
  const specialInput = ['radio', 'checkbox', 'file'];
  const textInput =
    'input:not([type=checkbox]):not([type=radio]):not([type=file])';

  if (specialInput.includes(watch)) {
    FORM_INPUTS = [
      ...FORM_INPUTS,
      ...Array.from(SELECTED_FORM.querySelectorAll(`input[type=${watch}]`)),
    ];
  } else if (
    watch.localeCompare('select') === 0 ||
    watch.localeCompare('textarea') === 0
  ) {
    FORM_INPUTS = [
      ...FORM_INPUTS,
      ...Array.from(SELECTED_FORM.querySelectorAll(watch)),
    ];
  } else {
    FORM_INPUTS = [
      ...FORM_INPUTS,
      ...Array.from(SELECTED_FORM.querySelectorAll(textInput)),
    ];
  }

  FORM_INPUTS = FORM_INPUTS.filter(
    (input) => !input.parentElement.classList.contains('disabled')
  );

  if (
    FORM_INPUTS.every((input) => input.value != null && input.value.length != 0)
  ) {
    FORM_HAS_EMPTY = FORM_HAS_INVALID = false;
    updateButtonState();
  }

  // console.log(FORM_INPUTS);

  switch (watch) {
    case 'input':
    case 'textarea':
      let timeout = setTimeout(function () {}, 0);
      let state = new Array();

      const inputs = FORM_INPUTS.filter((input) =>
        ['file', 'radio', 'checkbox'].every((s) => s != input.type)
      );

      for (let i = 0; i < inputs.length; i++) {
        state.push(inputIsEmpty(inputs[i]));
        // true -> empty / invalid
      }

      // console.log(inputs, state);

      inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
          clearTimeout(timeout);
          let error = new String();
          const upload = inputs.filter((i) => i.type == 'file')[0];

          state[index] = inputIsEmpty(input);
          // console.log(state);

          FORM_HAS_EMPTY = state.some((s) => s === true);

          if (upload != null) {
            FORM_HAS_EMPTY = fileHasNotBeenUploaded(upload)
              ? true
              : FORM_HAS_EMPTY;
          }

          if (!inputIsEmpty(input)) {
            error =
              input.localName.localeCompare('textarea') == 0
                ? isWithinMaxCharCount(input)
                : isCorrectFormat(input);

            state[index] = error != '' ? true : false;

            if (input.type == 'password') {
              const passwords = inputs.filter(
                (input) => input.type == 'password'
              );

              if (passwords.length == 2 && error == 'passmatch') {
                passwordMismatchError(input);
              } else if (passwords.length == 2 && error == '') {
                const index1 = inputs.findIndex((x) => x == passwords[0]);
                const index2 = inputs.findIndex((x) => x == passwords[1]);

                state[index1] = false;
                state[index2] = false;

                FORM_HAS_EMPTY = state.some((s) => s === true);
              }
            }
            FORM_HAS_INVALID = state[index];
          } else if (FORM_HAS_EMPTY) {
            error = 'empty';
          }

          // console.log(FORM_HAS_INVALID);

          let isErroneous =
            inputIsEmpty(input) || FORM_HAS_INVALID ? true : false;

          timeout = setTimeout(() => {
            // console.log(state);
            updateInputState(input, isErroneous, error);
            updateButtonState();
          }, 200);
        });
      });
      break;
    case 'file':
      const upload = FORM_INPUTS.filter((input) => input.type == 'file')[0];

      upload.addEventListener('change', () => {
        FORM_HAS_EMPTY = fileHasNotBeenUploaded(upload);
        showPreviewImage(upload);
        updateButtonState();
      });

      break;
    // case 'checkbox':
    //   FORM_HAS_EMPTY = checkboxesNotSelcted(FORM_INPUTS);
    //   break;
    // case 'radio':
    //   const radios = FORM_INPUTS.filter((input) => input.type == 'radio');

    //   FORM_HAS_EMPTY = radiosNotSelected(FORM_INPUTS);

    //   radios.forEach((radio) => {
    //     radio.addEventListener('click', () => {
    //       FORM_HAS_EMPTY = radiosNotSelected(FORM_INPUTS);
    //     });
    //   });

    //   // console.log(radiosNotSelected(FORM_INPUTS));
    //   break;
    // case 'select':
    //   FORM_HAS_EMTPY = selectNotSelected(FORM_INPUTS);
    //   break;
  }
}

function showPreviewImage(image) {
  const preview = URL.createObjectURL(image.files[0]);
  console.log(image.files[0]);
  const target = document.querySelector('#previewImg');

  target.classList.remove('visually-hidden');
  target.setAttribute('src', preview);
}

// Checks the FORM_HAS_EMPTY and FORM_HAS_INVALID flags; if both evaluate
// to true, then disable the submit button; else, enable it.
// WHEN: Call this function when all inputs have been verified.
function updateButtonState() {
  console.log(FORM_HAS_EMPTY, FORM_HAS_INVALID, FORM_HAS_REQUIRED);

  FORM_HAS_EMPTY
    ? FORM_HAS_REQUIRED
      ? disableSubmitBtn()
      : FORM_HAS_INVALID
      ? disableSubmitBtn()
      : enableSubmitBtn()
    : FORM_HAS_INVALID
    ? disableSubmitBtn()
    : enableSubmitBtn();
}
