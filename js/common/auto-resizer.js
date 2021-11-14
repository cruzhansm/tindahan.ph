window.onload = () => {
  
  const right = document.querySelector('.col.right');
  const lastElem = right.lastElementChild;

  if(right.offsetHeight == 1080 && lastElem.offsetHeight != 1080) {
    const offset = right.offsetHeight - lastElem.offsetHeight;
    right.style.minHeight = `${(1080 - offset).toString()}px`;
    console.log(right.offsetHeight); 
  }
}