import { countActiveUsers } from '/tindahan.ph/js/admin/db-methods/retrieve.js'
import { countPendingPartners } from '/tindahan.ph/js/admin/db-methods/retrieve.js'
import { countPendingListings } from '/tindahan.ph/js/admin/db-methods/retrieve.js'

window.onload = () => {
  countActiveUsers();
  countPendingPartners();
  countPendingListings();
}
