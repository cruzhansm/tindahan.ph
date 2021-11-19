window.onload = () => {
  
  const right = document.querySelector('.col.right');
  const rightHeight = right.offsetHeight;
  const lastElemHeight = right.lastElementChild.offsetHeight;

  if(rightHeight > 1080 && rightHeight != lastElemHeight) {
    right.style.height = `${rightHeight - lastElemHeight.toString()}px`;
  }
}