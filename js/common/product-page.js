function toggleReviews() {

  const productReviewArea = document.querySelector('.product-page-reviews');
  const productNoReviews = document.querySelector('#noReviews');
  const productListArea = document.querySelector('.product-page-review-list');
  
  if(productReviewArea.classList.contains('unpopulated')) {
    productReviewArea.classList.remove('unpopulated');
    productReviewArea.classList.add('populated');
  }
  else {
    productReviewArea.classList.remove('populated');
    productReviewArea.classList.add('unpopulated');
  }

  productListArea.classList.toggle('visually-hidden');
  productNoReviews.classList.toggle('visually-hidden');
}