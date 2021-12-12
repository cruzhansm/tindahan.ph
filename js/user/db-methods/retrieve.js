export async function userHasApplied() {
  return new Promise((resolve, reject) => {
    $.ajax({
      type: 'GET',
      url: '/tindahan.ph/php/user/crud.php',
      data: {
        type: 'partner-application-check',
      },
      success: (result) => {
        result = JSON.parse(result);

        resolve(result);
      },
    });
  });
}

export async function retrieveCartItems() {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/cart/crud.php',
    data: {
      type: 'get-cart-items',
    },
    success: (result) => {
      result = JSON.parse(result);
      console.log(result);

      return result;
    },
  });
}

export async function retrieveUserAddress() {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/user/crud.php',
    data: {
      type: 'retrieve-user-address',
    },
    success: (result) => {
      return JSON.parse(result);
    },
  });
}

export async function retrieveCurrentActiveOrder() {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/orders/crud.php',
    data: {
      type: 'retrieve-current-order',
    },
    success: (result) => {
      result = JSON.parse(result);
      return result;
    },
  });
}

export async function retrieveActiveVouchers() {
  return await $.ajax({
    type: 'GET',
    url: '/tindahan.ph/php/orders/crud.php',
    data: {
      type: 'retrieve-active-vouchers',
    },
    success: (result) => {
      return result != false ? result : [];
    },
  });
}
