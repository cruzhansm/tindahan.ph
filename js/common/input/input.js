function attachCharCountListener(listeningTo, countField, maxChar) {

  listeningTo.addEventListener('input', () => {
    let charCount = listeningTo.value.length;
    
    if(charCount <= maxChar) { countField.innerText = charCount; }
  });
}