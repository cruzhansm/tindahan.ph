import {
  noSubmit,
  disableSubmitBtn,
  attachEmptyFieldListeners,
} from '../input/form.js';

import { attachCharCountListener } from '../input/input.js';

// Makes the modal with the given id appear on screen. Then, it attaches
// event listeners for the input validation, depending on which inputs
// you want to validate through attachEmptyFieldListeners(inputType)
// WHEN: When you want to display a modal
// PARAMS: id of the specified modal
window.showModal = function showModal(selectedModal) {
  const modal = new bootstrap.Modal(selectedModal);
  const form = selectedModal.querySelector('form');

  modal.show();

  console.log(selectedModal);

  disableSubmitBtn(form)
    .then(attachEmptyFieldListeners('input'))
    .then(attachEmptyFieldListeners('textarea'))
    .then(
      attachCharCountListener(
        form.querySelector(`#${selectedModal.id}Msg`),
        form.querySelector(`#${selectedModal.id}MsgCount`)
      )
    )
    .catch(() => {
      console.log('BOOHOO');
    });
};

window.dismissModal = function dismissModal(selectedModal) {
  const modal = bootstrap.Modal.getInstance(selectedModal);

  modal.hide();
};

// Attempts to insert the report to the Reports table.
// PARAMS: event (submit event)
window.attemptSendReport = async function attemptSendReport(event) {
  noSubmit(event);

  const form = event.target;

  const report = {
    title: form.querySelector('input[type=text]').value,
    msg: form.querySelector('#reportMsg').value,
    imgs: Array.from(form.querySelector('input[type=file]').files),
  };

  console.log(report);
};

// Attempts to insert the feedback to the Feedback table.
// PARAMS: event (submit event)
window.attemptSendFeedback = async function attemptSendFeedback(event) {
  noSubmit(event);

  const form = event.target;

  const feedback = {
    title: form.querySelector('input[type=text]').value,
    msg: form.querySelector('#feedbackMsg').value,
    imgs: Array.from(form.querySelector('input[type=file]').files),
  };

  console.log(feedback);
};
