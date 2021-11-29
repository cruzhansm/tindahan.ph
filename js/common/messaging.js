function showMessages() {

  const containerMessage = document.querySelector('.container-messages');

  containerMessage.classList.remove('visually-hidden');
}

function hideMessages() {

  const containerMessage = document.querySelector('.container-messages');

  containerMessage.classList.add('visually-hidden');
}

// REFACTOR
function attachMessagingEventListener() {
  
  const messaging = document.querySelector('.container-messages');
  const messages = messaging.querySelector('.message-chat-area');
  const messageInputArea = messaging.querySelector('.message-chat-input-area');

  if(!messaging.classList.contains('visually-hidden')) {
    const messageInput = messaging.querySelector('.message-chat-msg-input');
    
    messages.style.height = `${380 - messageInputArea.offsetHeight}px`;

    messageInput.addEventListener('input', () => {
      setTimeout(() => {
        messageInput.style.cssText = `height: ${messageInput.scrollHeight}px;`;

        if(messageInput.scrollHeight > 39) {
          messageInput.scrollTop = messageInput.scrollHeight;
          messageInput.style.cssText += 'border-radius: 12px !important; ';
        }

        if(messageInput.value.length === 0) { 
          messageInput.style.cssText = `height: 39px; border-radius: 73px;`  
          messageInput.scrollTop = 0;
        }
      }, 0);
    });
  }
}

// TEMPORARY 
function noConvos() {

  const activeConvo = document.querySelector('.messages-conversation');
  const chatHide = document.querySelector('#chatNoActive');
  const chat = document.querySelector('#chatHide');
  const attachmentSent = Array.from(document.querySelectorAll('.attachmentSent'));
  const normalConvo = Array.from(document.querySelectorAll('.normalConvo'));

  if(!chat.classList.contains('visually-hidden')) {
    chat.classList.add('visually-hidden');
  }
  
  chatHide.classList.remove('visually-hidden');
  if(activeConvo.classList.contains('active')) {
    activeConvo.classList.remove('active');
  }

  if(!attachmentSent[0].classList.contains('visually-hidden')) {
    attachmentSent.forEach((elem) => {
      elem.classList.add('visually-hidden')
    })
  }
  else if(!normalConvo[0].classList.contains('visually-hidden')) {
    normalConvo.forEach((elem) => {
      elem.classList.add('visually-hidden');
    })
  }
}

function attachmentSentZ() {

  const activeConvo = document.querySelector('.messages-conversation');
  const chatHide = document.querySelector('#chatNoActive');
  const chat = document.querySelector('#chatHide');
  const attachmentSent = Array.from(document.querySelectorAll('.attachmentSent'));
  const normalConvo = Array.from(document.querySelectorAll('.normalConvo'));

  if(!activeConvo.classList.contains('active')) { 
    activeConvo.classList.add('active');
    chatHide.classList.add('visually-hidden');
  }

  chat.classList.remove('visually-hidden');

  if(normalConvo.every((elem) => { 
    return elem.classList.contains('visually-hidden') === false;
  })) {
    normalConvo.forEach((elem) => { elem.classList.add('visually-hidden') })
  }

  attachmentSent.forEach((elem) => {
    elem.classList.remove('visually-hidden');
  });
}

function normalConvos() {

  const activeConvo = document.querySelector('.messages-conversation');
  const chatHide = document.querySelector('#chatNoActive');
  const chat = document.querySelector('#chatHide');
  const attachmentSent = Array.from(document.querySelectorAll('.attachmentSent'));
  const normalConvo = Array.from(document.querySelectorAll('.normalConvo'));

  if(!activeConvo.classList.contains('active')) { 
    activeConvo.classList.add('active');
    chatHide.classList.add('visually-hidden');
  }

  chat.classList.remove('visually-hidden');

  if(attachmentSent.every((elem) => { 
    return elem.classList.contains('visually-hidden') === false;
  })) {
    attachmentSent.forEach((elem) => { elem.classList.add('visually-hidden') })
  }

  normalConvo.forEach((elem) => {
    elem.classList.remove('visually-hidden');
  });
}