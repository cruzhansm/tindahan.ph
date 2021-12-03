function displayUserActions() {
  let userActions = document.querySelector('.user-image-actions');

  userActions.classList.toggle('visually-hidden');
}

function logout() {
  $.ajax({
    type: 'POST',
    url: '/tindahan.ph/php/auth.php',
    data: {
      type: 'logout', 
    },
    success: () => {
      alert('logged out successfully.');
      window.location.href = '/tindahan.ph/src/common/login.php';
    },
  });
}
