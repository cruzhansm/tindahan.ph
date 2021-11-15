window.onload = () => {
  
  const right = document.querySelector('.col.right');
  const lastElem = right.lastElementChild;

  if(right.offsetHeight > 1080) {
    const height = (right.offsetHeight - lastElem.offsetHeight);
    right.style.height = `${height.toString()}px`;
  }
}