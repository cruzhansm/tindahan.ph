window.onload = () => { attachCharCountListener(shdesc, charcount, 200); }

function showRegisterForm() {

  const registerPrompt = document.querySelector('.register-prompt');
  const registerForm = document.querySelector('.register-form');
  const containerDisplay = document.querySelector('.container-display');
  const header = document.querySelector('.header');
  const right = document.querySelector('.right');

  containerDisplay.style.marginBottom = '33px';
  header.style.marginBottom = '33px';
  right.style.marginBottom = '90px';
  registerPrompt.classList.toggle('visually-hidden');
  registerForm.classList.toggle('visually-hidden');
}

function proceedToReview(e) {

  e.preventDefault();

  const registerForm = document.querySelector('.register-form');
  const registerReview = document.querySelector('.register-process');
  const right = document.querySelector('.right');

  right.style.marginBottom = '430px';
  registerForm.classList.toggle('visually-hidden');
  registerReview.classList.toggle('visually-hidden');
}