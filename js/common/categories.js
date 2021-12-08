window.onload = () => {

  let container = document.getElementById('categories-table');
  
  $.ajax({
    type: 'POST',
    url: '../../php/common/crud.php',
    data: {
      type: 'retrieve'
    },
    success: (data) => {
      console.log('hello');
      let resultData = JSON.parse(data);
      console.log(resultData);
      resultData.forEach ( x => {
        container.innerHTML +=
        `<a href='../common/categories-results.php?c=${x.category_id}' class='categories-box'>
            <img src='${x.category_img}' class='categories-box-img'>
            <div class='categories-box-title'>${x.category_name}</div>
          </a>`
          
      })
    }
  })
}