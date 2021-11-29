function showModal(selectedModal) {

  const modal = new bootstrap.Modal(selectedModal);

  modal.show();
}

function dismissModal(selectedModal) {

  const modal = bootstrap.Modal.getInstance(selectedModal);

  modal.hide();
}