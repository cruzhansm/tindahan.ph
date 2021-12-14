import { createUserList } from './db-methods/retrieve.js';

export var USERS = new Array();

window.onload = async () => {
  const usersCatcher = JSON.parse(await createUserList());
  appendUserTab(usersCatcher);
};

function appendUserTab(usersCatcher) {
  console.log(usersCatcher);
  let usersList = document.getElementById('admin-user-list');
  USERS = usersCatcher;
  console.log(USERS);
  usersCatcher.forEach((x) => {
    usersList.innerHTML += `<div class="admin-user" id="user${x.user_id}">
      <div class="admin-user-info">
        <div class="admin-user-info-highlight">
          <img src='${x.image}' class="admin-user-img" />
          <div class="admin-user-name">${x.fname} ${x.lname}</div>
        </div>
        <span class="admin-user-role">${
          x.role.charAt(0).toUpperCase() + x.role.slice(1)
        }</span
        ><span class="admin-user-id">ID#${x.user_id}</span>
      </div>
      <div class="admin-user-actions">
        ${
          x.suspended == 'false'
            ? `<button class="btn btn-tertiary" onclick="showSuspendModal(suspendModal, ${x.user_id})" id="btn${x.user_id}">Suspend</button>`
            : `<span class="tph-disabled">SUSPENDED</span>`
        }
        <button class="btn btn-tertiary" onclick="showDeleteModal(deleteModal, ${
          x.user_id
        })">Delete</button>
      </div>
    </div>`;
  });
}
