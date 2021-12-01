import {
  inputIsEmpty,
  checkboxesNotSelcted,
  radiosNotSelected,
  selectNotSelected,
  updateInputState,
  isCorrectFormat,
  passwordMismatchError,
} from './input.js';

var SELECTED_FORM; // Current form being evaluated
var FORM_HAS_EMPTY = true; // Determines if current form has empty fields
var FORM_HAS_INVALID = true; // Determines if current form has invalid inputs

// Prevent form submission, used for AJAX requests
// WHEN: Call this during form submission / clicking of submit button
// PARAMS: current event (simply pass event)
export function noSubmit(event) {
  event.preventDefault();
}

// Disables the submit button of form when one or more fields are empty
// WHEN: Call this function on window.onload of page that contains a form
// PARAMS: the form itself (typeof HTMLElement)
export function disableSubmitBtn(form) {
  form = form || SELECTED_FORM;
  const submit = form.querySelector('button[type=submit]');

  SELECTED_FORM = form;

  if (!submit.classList.contains('tph-disabled')) {
    submit.classList.add('tph-disabled'); // css/components/button.css
  }

  return form == undefined || submit == undefined
    ? Promise.reject('Non-existent form or button.')
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
  const specialInput = ['radio', 'checkbox'];
  const textInput = 'input:not([type=checkbox]):not([type=radio])';
  let inputs = new Array();

  if (specialInput.includes(watch)) {
    inputs = Array.from(SELECTED_FORM.querySelectorAll(`input[type=${watch}]`));
  } else if (watch.localeCompare('select') === 0) {
    inputs = Array.from(SELECTED_FORM.querySelectorAll(watch));
  } else {
    inputs = Array.from(SELECTED_FORM.querySelectorAll(textInput));
  }

  console.log(inputs);

  switch (watch) {
    case 'input':
    case 'textarea':
      let timeout = setTimeout(function () {}, 0);
      let state = new Array();

      for (let i = 0; i < inputs.length; i++) {
        state.push(true);
        // true -> empty / invalid
      }

      inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
          clearTimeout(timeout);
          let error = new String();

          state[index] = inputIsEmpty(input);

          FORM_HAS_EMPTY = state.some((s) => s === true);

          if (!inputIsEmpty(input)) {
            error = isCorrectFormat(input);

            state[index] = error != '' ? true : false;

            if (input.type == 'password') {
              const passwords = inputs.filter(
                (input) => input.type == 'password'
              );

              if (passwords.length == 2 && error == 'passmatch') {
                passwordMismatchError(input);
              } else if (passwords.length == 2 && error == '') {
                console.log('hello');
                const index1 = inputs.findIndex((x) => x == passwords[0]);
                const index2 = inputs.findIndex((x) => x == passwords[1]);

                state[index1] = false;
                state[index2] = false;
                FORM_HAS_EMPTY = state.some((s) => s === true);
              }
            }

            FORM_HAS_INVALID = state[index];
          } else {
            error = 'empty';
          }

          let isErroneous =
            inputIsEmpty(input) || FORM_HAS_INVALID ? true : false;

          timeout = setTimeout(() => {
            updateInputState(input, isErroneous, error);
            updateButtonState();
          }, 200);
        });
      });
      break;
    case 'checkbox':
      FORM_HAS_EMPTY = checkboxesNotSelcted(inputs);
      break;
    case 'radio':
      FORM_HAS_EMPTY = radiosNotSelected(inputs);
      break;
    case 'select':
      FORM_HAS_EMTPY = selectNotSelected(inputs);
      break;
  }
}

// Checks the FORM_HAS_EMPTY and FORM_HAS_INVALID flags; if both evaluate
// to true, then disable the submit button; else, enable it.
// WHEN: Call this function when all inputs have been verified.
function updateButtonState() {
  FORM_HAS_EMPTY
    ? disableSubmitBtn()
    : FORM_HAS_INVALID
    ? disableSubmitBtn()
    : enableSubmitBtn();
}
