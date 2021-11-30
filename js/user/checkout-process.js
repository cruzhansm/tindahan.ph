window.onload = () => { 
  awaitPaymentChoice();
  adjustButtonsPosition(); 
};

function nextStep(event) {
  
  const progress = Array
                .from(document.querySelectorAll('.checkout-progress-step'))
                .filter((step) => { 
                  if(!step.classList.contains('done')) { return step; }
                })[0];
  const process = Array
                .from(document.querySelectorAll('.container-checkout-process'))
                .filter((step) => {
                  if(!step.classList.contains('visually-hidden')) { 
                    return step; 
                  }
                })[0];
        
  event = event || null;

  if(event != null) { noSubmit(event); }

  progress.classList.toggle('done');
  process.nextElementSibling.classList.toggle('visually-hidden');
  process.classList.toggle('visually-hidden');

  // DISABLE ADJUSTING OF BUTTON POSITIONS IF IN STEP 2 OR 4
  if(progress.innerText != '2' && progress.innerText != '4') {
    adjustButtonsPosition();
  }
}

function previousStep() {
  
  let progress = Array
                .from(document.querySelectorAll('.checkout-progress-step'))
                .filter((step) => { 
                  if(step.classList.contains('done')) { return step; }
                });
  const process = Array
                .from(document.querySelectorAll('.container-checkout-process'))
                .filter((step) => {
                  if(!step.classList.contains('visually-hidden')) { 
                    return step; 
                  }
                })[0];
  progress = progress[progress.length - 1];

  // ADJUST 3RD STEP BUTTON GROUP POSITION
  if(progress.innerText == '3') { adjustButtonsPosition(); }

  progress.classList.toggle('done');
  process.previousElementSibling.classList.toggle('visually-hidden');
  process.classList.toggle('visually-hidden');
}

function awaitPaymentChoice() {

  const radios = document.querySelectorAll('input[type=radio]');
  const creditCard = document.querySelector('#cc');
  const cashOnDelivery = document.querySelector('#cod');
  const form = document.querySelector('#ccform');

  radios.forEach((radio) => {
    radio.addEventListener('change', () => {
      const buttons = Array
                .from(document.querySelectorAll('.container-checkout-process'))
                .filter((process) => {
                  if(!process.classList.contains('visually-hidden')) {
                    return process;
                  }
                })[0].querySelector('.container-button-group');
      let selected = document.querySelector('input[type=radio]:checked');

      if(selected == creditCard ||
         selected == cashOnDelivery && 
         !form.classList.contains('visually-hidden')) {
        form.classList.toggle('visually-hidden');
      }

      if(selected == creditCard) { 
        const formHeight = document.querySelector('#payment').offsetHeight;
        
        buttons.style.marginTop = `${window.innerHeight - (formHeight - 135)}px`;
      }
      else {     
        buttons.style.marginTop = `${window.innerHeight - 538}px`;
      }
    });
  });
}

function adjustButtonsPosition() {

  const container = document.querySelector('.container-display');
  const active = Array
              .from(document.querySelectorAll('.container-checkout-process'))
              .filter((process) => {
                if(!process.classList.contains('visually-hidden')) {
                  return process;
                }
              })[0];
  const buttonGroup = active.querySelector('.container-button-group');
  const containerHeight = container.offsetHeight + 166;

  let offset = window.innerHeight - containerHeight;

  console.log(`Container ${containerHeight}`);
  console.log(`Offset ${offset}`)

  buttonGroup.style.marginTop = `${offset}px`;
}

function redirectPreviousURL() {

  window.history.back();
}