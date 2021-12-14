import { getThreeLatestFromVarious } from './db-methods/retrieve.js';
import { countActiveUsers } from '/tindahan.ph/js/admin/db-methods/retrieve.js';
import { countPendingPartners } from '/tindahan.ph/js/admin/db-methods/retrieve.js';
import { countPendingListings } from '/tindahan.ph/js/admin/db-methods/retrieve.js';

window.onload = async () => {
  countActiveUsers();
  countPendingPartners();
  countPendingListings();

  const latest = JSON.parse(await getThreeLatestFromVarious());

  console.log(latest);

  appendAllLatest(latest);
};

function appendAllLatest(latest) {
  const userContainer = document.querySelector('#users');
  const applicationContainer = document.querySelector('#applications');
  const listingContainer = document.querySelector('#listings');

  let tab = document.createElement('div');
  tab.classList.add('trending-tab', 'rounded');

  latest.users.forEach((user) => {
    tab.innerHTML += `
      <div class="trending-tab-product">
        <div class="trending-tab-product-img"></div>
        <div class="trending-tab-product-data">
          <div>${user.name}</div>
          <div>User #${user.user_id}</div>
        </div>
      </div>
      <div class="trending-tab-sales">${user.last_login.split(' ')[0]}</div>
    `;
  });

  userContainer.append(tab);

  tab = document.createElement('div');
  tab.classList.add('trending-tab', 'rounded');

  latest.applications.forEach((application) => {
    tab.innerHTML += `
    <div class="trending-tab-product">
      <div class="trending-tab-product-img"></div>
      <div class="trending-tab-product-data">
        <div>${application.store_name}</div>
        <div>User #${application.application_id}</div>
      </div>
    </div>
    <div class="trending-tab-sales">${application.name}</div>
    `;
  });

  applicationContainer.append(tab);

  tab = document.createElement('div');
  tab.classList.add('trending-tab', 'rounded');

  latest.listings.forEach((listing) => {
    tab.innerHTML += `
    <div class="trending-tab-product">
      <div class="trending-tab-product-img"></div>
      <div class="trending-tab-product-data">
        <div>${listing.listing_name}</div>
        <div>User #${listing.application_id}</div>
      </div>
    </div>
    <div class="trending-tab-sales">${listing.store_name}</div>
    `;
  });

  listingContainer.append(tab);
}
