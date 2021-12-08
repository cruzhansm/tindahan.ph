window.onload = () => {
  countActiveUsers();
  countPendingPartners();
  countPendingListings();
}

function countActiveUsers() {
  let activeUsers = document.getElementById('active-users');

  $.ajax({
    url: '../../php/admin/crud.php',
    data: {
      type: 'count-users'
    },
    success: (data) => {
      activeUsers.innerHTML += `${data}`
    }
  });
}

function countPendingPartners() {
  let pendingPartners = document.getElementById('pending-partners');
  
  $.ajax({
    url: '../../php/admin/crud.php',
    data: {
      type: 'count-pending-partners'
    },
    success: (data) => {
      pendingPartners.innerHTML += `${data}`
    }
  });
}

function countPendingListings() {
  let pendingListings = document.getElementById('pending-listings');

  $.ajax ({
    url: '../../php/admin/crud.php',
    data: {
      type: 'count-pending-listings'
    },
    success: (data) => {
      pendingListings.innerHTML += `${data}`
    }
  });
}