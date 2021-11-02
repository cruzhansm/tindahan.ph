function goToNextPage(npage) {
  let current = document.querySelector('.page-link.current');
  let next = current.parentElement.parentElement;
  let cpage = document.querySelector('.page-link.current').innerText;

  next = next.getElementsByTagName('li')[npage].childNodes[1];

  console.log("Current Page: " + cpage);
  console.log("Going to: " + npage);

  cpage = document.querySelector('#pagination' + cpage);
  npage = document.querySelector('#pagination' + npage);

  cpage.classList.toggle('visually-hidden');
  npage.classList.toggle('visually-hidden');

  current.classList.remove('current');
  next.classList.add('current');
}

function goToPredecessor() {
  let cpage = document.querySelector('.page-link.current').innerText;
  cpage = parseInt(cpage);

  if(cpage != 1) {
    let npage = document.querySelector('.pagination');
    let current = document.querySelector('.page-link.current');
    let next = Array.from(npage.querySelectorAll('.page-link'))[cpage - 1];

    npage = next.innerText;

    console.log("Current Page: " + cpage);
    console.log("Going to: " + npage);

    cpage = document.querySelector('#pagination' + cpage);
    npage = document.querySelector('#pagination' + npage);

    cpage.classList.toggle('visually-hidden');
    npage.classList.toggle('visually-hidden');

    current.classList.remove('current');
    next.classList.add('current');
  }
}

function goToSuccessor() {
  let cpage = document.querySelector('.page-link.current').innerText;
  cpage = parseInt(cpage);

  if(cpage != 3) {
    let npage = document.querySelector('.pagination');
    let current = document.querySelector('.page-link.current');
    let next = Array.from(npage.querySelectorAll('.page-link'))[cpage + 1];

    npage = next.innerText;

    console.log("Current Page: " + cpage);
    console.log("Going to: " + npage);

    cpage = document.querySelector('#pagination' + cpage);
    npage = document.querySelector('#pagination' + npage);

    cpage.classList.toggle('visually-hidden');
    npage.classList.toggle('visually-hidden');

    current.classList.remove('current');
    next.classList.add('current');
  }
}