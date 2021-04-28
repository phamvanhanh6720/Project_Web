// num product in cart DONE 
function ready(fn) {
    if (document.readyState != 'loading') {
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }
  ready(() => {
    var temp = document.querySelectorAll('.num-order');
    if (temp === null) return;
    temp.forEach(element =>
      element.addEventListener('change', function () {
        var product_id = element.getAttribute('data-id');
        var qty = element ? element.value : "";
        var data = { product_id: product_id, qty: qty };
        console.log(data);
        fetch('?mod=cart&controller=index&action=update_cart', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `product_id=${product_id}&qty=${qty}`
        })
          .then((response) => {
            if (!response.ok) {
              throw Error(response.statusText);
            }
            console.log(response);
            return response;
          })
          .then(function (response) { return response.json() })
          .then(function (data) {
            document.querySelector('#sub-total-' + product_id).textContent = data.sub_total;
            document.querySelector('#total-price span').textContent = data.total;
          })
          .catch((xhr, ajaxoptions, thrownError, data) => {
            console.log("Lỗi CMNR");
          });
      }));
  });
  
  //list product
  ready(() => {
    function get_data(cat_id, page_num) {
      var arrange = document.querySelector("#filter-arrange option:checked").value;
      var data = { page_num: page_num, cat_id: cat_id, arrange: arrange };
      console.log(data);
      fetch('?mod=product&controller=index&action=product', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `page_num=${page_num}&cat_id=${cat_id}&arrange=${arrange}`,
      }).
        then((response) => {
          if (!response.ok) {
            throw Error(response.statusText);
          }
          return response;
        })
        .then((response) => response.json())
        .then((data) => {
          document.getElementById(cat_id).innerHTML = data.output;
        });
    };
    document.getElementById("main-content-wp").addEventListener("click", function (e) {
      if (e.target && e.target.classList.contains("num-page")) {
        var cat_id = e.target.getAttribute('cat-id');
        var page_num = e.target.textContent;
        get_data(cat_id, page_num);
      }
    });
  });
  
  // pagination cat
  ready(() => {
    function ferch_data(page_num) {
      function get_filter(class_name) {
        var filter = [];
        var temp = document.getElementsByClassName(class_name);
        for (var i = 0; i < temp.length; i++) {
          if (temp[i].checked) filter.push(temp[i].value);
        };
        console.log(filter);
        return filter;
      }
      var price = get_filter('filter-price');
      var brand = get_filter('filter-brand');
      var cat_id = document.getElementById('cat-title').getAttribute('cat-id');
      var arrange = document.getElementById('filter-arrange').value;
      var data = { page_num: page_num, cat_id: cat_id, price: price, brand: brand, arrange: arrange };
      console.log(data);
      fetch('?mod=product&controller=index&action=pagination_cat', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `page_num=${page_num}&cat_id=${cat_id}&price=${price}&brand=${brand}&arrange=${arrange}`
      })
        .then((response) => {
          if (!response.ok) {
            throw Error(response.statusText);
          }
          console.log(response);
          return response;
        })
        .then((response) => response.json())
        .then((data) => {
          document.getElementById('result-product-cat').innerHTML = data.output;
          document.getElementById('num-page').textContent = data.num_page;
          document.getElementById('num-filter').textContent = data.num_filter;
        })
        .catch((xhr, ajaxoptions, thrownError) => {
          console.log("ERROR: " + thrownError + ", " + xhr.status);
        });
    }
    // ferch_data();
    document.getElementById("main-content-wp").addEventListener("click", function (e) {
      if (e.target && e.target.classList.contains("common_selector")) {
        var page_num = e.target.textContent;
        ferch_data(page_num);
      };
    });
  });
  
  // pagination post
  ready(() => {
    function get_data(page_num) {
      var data = { page_num: page_num };
      console.log(data);
      fetch('?mod=blog&controller=index&action=pagination_post', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `page_num=${page_num}`
      })
        .then((response) => {
          if (!response.ok) {
            throw Error(response.statusText);
          }
          console.log(response);
          return response;
        })
        .then((response) => response.json())
        .then((data) => {
          document.getElementById('result_post').innerHTML = data.result_post;
        })
        .catch((xhr, ajaxoptions, thrownError) => {
          console.log("ERROR: " + thrownError + ", " + xhr.status);
        });
    };
    document.getElementById("main-content-wp").addEventListener("click", function (e) {
      if (e.target && e.target.classList.contains("common_selector_post")) {
        var page_num = e.target.textContent;
        get_data(page_num);
      }
    });
  });
  
  
  // pagination search
  ready(() => {
    function get_data(page_num, cat_id, value) {
      var arrange = document.querySelector("#filter-arrange option:checked").value;
      var data = { page_num: page_num, cat_id: cat_id, value: value, arrange: arrange };
      console.log(data);
      fetch('?mod=home&controller=index&action=pagination_search', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `page_num=${page_num}&cat_id=${cat_id}&value=${value}&arrange=${arrange}`
      })
        .then((response) => {
          if (!response.ok) {
            throw Error(response.statusText);
          }
          console.log(response);
          return response;
        })
        .then((response) => response.json())
        .then((data) => {
          document.getElementById(cat_id).innerHTML = data.result_search;
        })
        .catch((xhr, ajaxoptions, thrownError) => {
          console.log("ERROR: " + thrownError + ", " + xhr.status);
        });
    };
    document.getElementById("main-content-wp").addEventListener("click", function (e) {
      if (e.target && e.target.classList.contains("common_selector_search")) {
        var page_num = e.target.textContent;
        var cat_id = e.target.getAttribute('cat-id');
        var value = e.target.getAttribute('value');
        get_data(page_num, cat_id, value);
      }
    });
  });
  // LOADDING PAGE DONE
  window.addEventListener('load', function () {
    const temp = document.querySelector('.loader');
    if (temp === null) return;
    temp.classList.add('hide');
    temp.classList.remove('show');
  });
  //================
  // SELECT ADDRESS OF PAYMENT
  //================
  
  //  select district 
  ready(() => {
    var temp = document.querySelectorAll('.province');
    if (temp === null) return;
    temp.forEach(element =>
      element.addEventListener('change', function () {
        var province = element.value;
        var data = { province: province };
        console.log(data);
        fetch('?mod=cart&action=select_district', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `province=${province}`
        })
          .then((response) => {
            if (!response.ok) {
              throw Error(response.statusText);
            }
            console.log(response);
            return response;
          })
          .then((response) => response.text())
          .then((data) => {
            document.querySelector('.district').innerHTML = data;
          })
          .catch((xhr, ajaxoptions, thrownError) => {
            console.log("ERR  OR: " + thrownError + ", " + xhr.status);
          });
      }));
  });
  
  //  select commune 
  ready(() => {
    var temp = document.querySelectorAll('.district');
    if (temp === null) return;
    temp.forEach(element =>
      element.addEventListener('change', function () {
        var district = element.value;
        var data = { district: district };
        console.log(data);
        fetch('?mod=cart&action=select_commune', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `district=${district}`
        })
          .then((response) => {
            if (!response.ok) {
              throw Error(response.statusText);
            }
            console.log(response);
            return response;
          })
          .then((response) => response.text())
          .then((data) => {
            document.querySelector('.commune').innerHTML = data;
          })
          .catch((xhr, ajaxoptions, thrownError) => {
            console.log("ERR  OR: " + thrownError + ", " + xhr.status);
          });
      }));
  });
  