
const search_input = document.getElementById("input_search");

search_input.addEventListener("input", function (event) {
    event.preventDefault();

    var search_text = document.getElementById("input_search").value;
    

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var data = "search_text=" + encodeURIComponent(search_text) + "&type=search_products";

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var responseData = JSON.parse(xhr.responseText);
            
            updateProducts(responseData);
        }
    };

    xhr.send(data);

});



const btns_add_cart = document.querySelectorAll(".btn-add-cart");

btns_add_cart.forEach(btn_add_cart => {
  btn_add_cart.addEventListener("click", function (event) {
    const id = btn_add_cart.dataset.id;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var data = "type=add_to_cart&id=" + id

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.IsInCart) {
          alert("Товар додано до кошику");
        } else {
          alert("Товар вже є у кошику");
        }
      }
    };

    xhr.send(data);
  });
});

const select_category = document.getElementById("products-category");
select_category.addEventListener("change", function (event) {
  event.preventDefault();

  var category = document.getElementById("products-category").value;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "", true);

  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  var data = "category=" + encodeURIComponent(category) + "&type=products_category";

  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      updateProducts(responseData); 
    }
  };

  xhr.send(data);
});


function attachAddToCartListener() {
  const btns_add_cart = document.querySelectorAll(".btn-add-cart");

  btns_add_cart.forEach(btn_add_cart => {
    btn_add_cart.addEventListener("click", function (event) {
      const id = btn_add_cart.dataset.id;

      var xhr = new XMLHttpRequest();
      xhr.open("POST", "", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      var data = "type=add_to_cart&id=" + id

      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.IsInCart) {
            alert("Товар додано до кошику");
          } else {
            alert("Товар вже є у кошику");
          }
        }
      };

      xhr.send(data);
    });
  });
}

function updateProducts(data) {
  var productsContainer = document.querySelector(".products");
  productsContainer.innerHTML = ""; 

  if (Array.isArray(data)) {
    data.forEach(function (product) {
      var productElement = document.createElement("div");
      productElement.className = "product font-size-14 font-family";

      productElement.innerHTML = `
                <div class="image-product">
                    <img src="/../pyrotehnic/public/assets/webstore/img/products/${product.path_image}">
                </div>
                <div class="text-product">
                  <span class="name">${product.category} ${product.name}</span>
                  <span class="count">"в упаковці ${product.count} шт.</span>
                  <span class="price">${product.price} грн.</span>
                  <button class="btn-add-cart" data-id="${product.id}">У кошик</button>
                </div>
            `;

      productsContainer.appendChild(productElement);
    });

    attachAddToCartListener();
  }
}