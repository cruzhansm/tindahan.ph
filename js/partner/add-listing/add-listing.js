upload_img.onchange = evt=>{
  const[file]=upload_img.files;
  if(file){
    previewImg.src = URL.createObjectURL(file);
    previewImg.classList.remove("visually-hidden"); 
  }
}

function createPartnerNavbar() {
  return `<a href="../tindahan.ph/index.php" class="sidenav-link">
            <i class="fa-solid fa-house-chimney sidenav-link-icon"></i>
            <div class="sidenav-link-text">Home</div>
          </a>
          <a href="src/common/categories.php" class="sidenav-link">
            <i class="fa-solid fa-cubes sidenav-link-icon"></i>
            <div class="sidenav-link-text">Categories</div>
          </a>
          <a
            href="src/partner/partner-shop-profile.php"
            class="sidenav-link"
          >
            <i class="fa-solid fa-shop sidenav-link-icon"></i>
            <div class="sidenav-link-text">Shop Profile</div>
          </a>
          <a href="src/partner/partner-add-listing.php" class="sidenav-link active">
            <i class="fa-solid fa-circle-plus sidenav-link-icon"></i>
            <div class="sidenav-link-text">Add Listing</div>
          </a>
          <a href="src/partner/partner-orders.html" class="sidenav-link">
            <i class="fa-solid fa-receipt sidenav-link-icon"></i>
            <div class="sidenav-link-text">Orders</div>
          </a>
          <a href="src/common/help-center.html" class="sidenav-link">
            <i class="fa-solid fa-headset sidenav-link-icon"></i>
            <div class="sidenav-link-text">Help Center</div>
          </a>`;
}