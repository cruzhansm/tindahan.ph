function showAccordion(accordion) {
  const accordionGroup = document.querySelector(
    '.container-help-accordion-group'
  );
  const helpCenter = document.querySelector('.container-help');

  accordionGroup.classList.remove('visually-hidden');
  helpCenter.classList.add('visually-hidden');
  accordion.classList.remove('visually-hidden');
}
