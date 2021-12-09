export class Pagination {
  controller;
  links;
  currentPage;
  previousPage;
  previousController;
  nextPage;
  nextController;
  pageTotal;
  isVisible;

  constructor(container, pageTotal, isVisible) {
    this.pageTotal = Math.ceil(pageTotal);

    this.preparePages('paginationPages');

    this.controller = this.#createController(pageTotal);
    this.isVisible = isVisible;

    if (isVisible) {
      document.querySelector(`#${container}`).append(this.controller);
    } else {
      return;
    }

    this.links = Array.from(
      document
        .querySelector(`#${container}`)
        .childNodes[0].querySelectorAll('li')
    );

    this.currentPage = 1;
    this.previousPage = 0;
    this.previousController = this.links[0];
    this.nextPage = 2;
    this.nextController = this.links[this.links.length - 1];

    this.#initPagination();
  }

  #createController() {
    const pagination = document.createElement('ul');

    pagination.classList.add('pagination', 'justify-content-center');

    pagination.innerHTML = `
      <li class="page-item">
        <a href="#page${1}" class="page-link">Previous</a>
      </li>
    `;

    for (let i = 1; i <= this.pageTotal; i++) {
      pagination.innerHTML += `
        <li class="page-item">
          <a href="#page${i}" class="page-link ${
        i == 1 ? 'current' : ''
      }">${i}</a>
        </li>
      `;
    }

    pagination.innerHTML += `
      <li class="page-item">
        <a href="#page${2}" class="page-link">Next</a>
      </li>
    `;

    return pagination;
  }

  #initPagination() {
    this.nextController.addEventListener('click', () => this.next());
    this.previousController.addEventListener('click', () => this.previous());

    this.links.forEach((link, index) => {
      index == 0 || index == this.links.length - 1
        ? ''
        : link.firstElementChild.addEventListener('click', () =>
            this.goToPage()
          );
    });
  }

  next() {
    if (this.currentPage == this.pageTotal) return;

    const oldActive = this.links[this.currentPage].firstElementChild;
    const oldActivePage = document.querySelector(`#page${this.currentPage}`);
    const newActive = this.links[this.nextPage].firstElementChild;
    const newActivePage = document.querySelector(`#page${this.nextPage}`);

    oldActive.classList.remove('current');
    newActive.classList.add('current');

    oldActivePage.classList.add('visually-hidden');
    newActivePage.classList.remove('visually-hidden');

    this.previousPage = this.currentPage;
    this.currentPage = this.nextPage;
    this.nextPage < this.pageTotal ? this.nextPage++ : '';

    this.nextController.firstElementChild.setAttribute(
      'href',
      `#page${this.currentPage}`
    );
  }

  previous() {
    if (this.currentPage == 1) return;

    const oldActive = this.links[this.currentPage].firstElementChild;
    const oldActivePage = document.querySelector(`#page${this.currentPage}`);
    const newActive = this.links[this.previousPage].firstElementChild;
    const newActivePage = document.querySelector(`#page${this.previousPage}`);

    oldActive.classList.remove('current');
    newActive.classList.add('current');

    newActivePage.classList.remove('visually-hidden');
    oldActivePage.classList.add('visually-hidden');

    this.nextPage = this.currentPage;
    this.currentPage = this.previousPage;
    this.previousPage > 0 ? this.previousPage-- : '';

    this.previousController.firstElementChild.setAttribute(
      'href',
      `#page${this.currentPage}`
    );
  }

  goToPage() {
    const goTo = parseInt(
      window.event.target.getAttribute('href').match(/(\d+)/)[0]
    );

    const oldActive = this.links[this.currentPage].firstElementChild;
    const oldActivePage = document.querySelector(`#page${this.currentPage}`);
    const newActive = this.links[goTo].firstElementChild;
    const newActivePage = document.querySelector(`#page${goTo}`);

    oldActive.classList.remove('current');
    newActive.classList.add('current');

    newActivePage.classList.remove('visually-hidden');
    oldActivePage.classList.add('visually-hidden');

    this.currentPage = goTo;

    this.previousPage =
      this.currentPage > 1 ? this.currentPage - 1 : this.currentPage;
    this.nextPage =
      this.currentPage < this.pageTotal
        ? this.currentPage + 1
        : this.currentPage;
  }

  preparePages(container) {
    let target = document.querySelector(`#${container}`);

    for (let i = 1; i <= this.pageTotal; i++) {
      let page = document.createElement('div');

      page.classList.add('pagination-page');
      i != 1 ? page.classList.add('visually-hidden') : '';
      page.setAttribute('id', `page${i}`);

      target.append(page);
    }
  }
}
