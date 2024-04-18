
const add_btn = document.getElementById("btnSubmitAddProduct");

add_btn.addEventListener("click", function (event) {
    event.preventDefault();

    var name = document.getElementById("name").value;
    var price = document.getElementById("price").value;
    var category = document.getElementById("category").value;
    var country = document.getElementById("country").value;
    var count = document.getElementById("count").value;
    var description = document.getElementById("description").value;
    var path_image = document.getElementById("path_image").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var data = "name=" + encodeURIComponent(name) + "&price=" + encodeURIComponent(price) + "&category=" + encodeURIComponent(category) + "&country=" +
        encodeURIComponent(country) + "&count=" + encodeURIComponent(count) +
        "&description=" + encodeURIComponent(description) + "&path_image=" + encodeURIComponent(path_image) + "&type=add_product";

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var responseData = JSON.parse(xhr.responseText);
            updateTable(responseData);


            document.getElementById("name").value = "";
            document.getElementById("price").value = "";
            document.getElementById("category").value = "";
            document.getElementById("country").value = "";
            document.getElementById("count").value = "";
            document.getElementById("description").value = "";
            document.getElementById("path_image").value = "";

            console.log('Response:', xhr.responseText);
        }
    };

    xhr.send(data);
});


document.addEventListener("DOMContentLoaded", function () {
    var tableBody = document.querySelector("#adminTable tbody");

    tableBody.addEventListener("click", function (event) {
        if (event.target.classList.contains("delete")) {
            var id = event.target.getAttribute("data-id");
            deleteProduct(id);
        }
        if (event.target.classList.contains("edit")) {
            var id = event.target.getAttribute("data-id");
            openModalEditWindow(id);
        }
    });
});


function openModalEditWindow(id) {
    window.history.pushState({}, '', '?id=' + id);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var data = "id=" + encodeURIComponent(id) + "&type=get_product";
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var productData = JSON.parse(xhr.responseText);

            document.getElementById("name_edit").value = productData.name;
            document.getElementById("price_edit").value = productData.price;
            document.getElementById("category_edit").value = productData.category;
            document.getElementById("country_edit").value = productData.country;
            document.getElementById("count_edit").value = productData.count;
            document.getElementById("description_edit").value = productData.description;
            document.getElementById("path_image_edit").value = productData.path_image;
            
            $("#editProductModal").css("display", "block");
        }
    };

    xhr.send(data);
}

function editProduct() {

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    var name = document.getElementById("name_edit").value;
    var price = document.getElementById("price_edit").value;
    var category = document.getElementById("category_edit").value;
    var country = document.getElementById("country_edit").value;
    var count = document.getElementById("count_edit").value;
    var description = document.getElementById("description_edit").value;
    var path_image = document.getElementById("path_image_edit").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var dataEdit = "id=" + encodeURIComponent(id) + "&name=" + encodeURIComponent(name) +
        "&price=" + encodeURIComponent(price) + "&category=" + encodeURIComponent(category) +
        "&country=" + encodeURIComponent(country) + "&count=" + encodeURIComponent(count) +
        "&description=" + encodeURIComponent(description) + "&path_image=" + encodeURIComponent(path_image) + "&type=edit_product";

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var responseDataEdit = JSON.parse(xhr.responseText);
            updateTable(responseDataEdit);

            document.getElementById("name_edit").value = "";
            document.getElementById("price_edit").value = "";
            document.getElementById("category_edit").value = "";
            document.getElementById("country_edit").value = "";
            document.getElementById("count_edit").value = "";
            document.getElementById("description_edit").value = "";
            document.getElementById("path_image_edit").value = "";

            console.log('Response:', xhr.responseText);

            window.history.replaceState({}, document.title, window.location.pathname);
        }
    };

    xhr.send(dataEdit);
}


function deleteProduct(id) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var data2 = "id=" + encodeURIComponent(id) + "&type2=delete_product";
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var responseData2 = JSON.parse(xhr.responseText);
            updateTable(responseData2);

            console.log('Response:', xhr.responseText);
        }
    };


    xhr.send(data2);
}

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
            
            updateTable(responseData);
            console.log('Response:', xhr.responseText);
        }
    };

    xhr.send(data);

});

var sortDirection = "asc"; 
var sortField = "id";

document.addEventListener("DOMContentLoaded", function () {
    var tableHeader = document.querySelector("#adminTable thead");

    tableHeader.addEventListener("click", function (event) {
        if (event.target.tagName === "TH") {
            var fieldName = event.target.innerText.toLowerCase();
            if (fieldName == 'назва')
            {
                fieldName = 'name';
            }
            else if (fieldName == 'опис')
            {
                fieldName = 'description';
            }
            else if (fieldName == 'ціна')
            {
                fieldName = 'price'
            }
            else if (fieldName == 'кількість')
            {
                fieldName = 'count';
            }
            else if (fieldName == 'країна')
            {
                fieldName = 'country';
            }
            else if (fieldName == 'категорія')
            {
                fieldName = 'category';
            }
            else {fieldName = 'id'}
            if (sortField === fieldName) {
                sortDirection = (sortDirection === "asc") ? "desc" : "asc";
            } else {
                sortField = fieldName;
                sortDirection = "asc";
            }

            sortProduct(sortField, sortDirection);
        }
    });
});


function sortProduct(sortField, sortDirection)
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var data = "sort_field=" + encodeURIComponent(sortField) + "&sort_direction=" + encodeURIComponent(sortDirection) + "&type=sort_products";

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var sortedData = JSON.parse(xhr.responseText);
            updateTable(sortedData);
        }
    };

    xhr.send(data);
}


const category_products = document.getElementById("get-category-products");
category_products.addEventListener("change", function (event) {
    event.preventDefault();

    var category = document.getElementById("get-category-products").value;
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "category=" + encodeURIComponent(category) + "&type=get_category_products";

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var responseData = JSON.parse(xhr.responseText);
            
            updateTable(responseData);
        }
    };

    xhr.send(data);

});


function updateTable(data) {
    var tableBody = document.querySelector("#adminTable tbody");
    tableBody.innerHTML = "";

    data.forEach(function (product) {
        var row = document.createElement("tr");
        row.innerHTML = `<td>${product.id}</td>
                         <td>${product.name}</td>
                         <td class="description">${product.description}</td>
                         <td>${product.price} грн.</td>
                         <td>${product.count} шт.</td>
                         <td>${product.country}</td>
                         <td>${product.category}</td>
                         <td><img src="/../pyrotehnic/public/assets/webstore/img/products/${product.path_image}" style="width: 100px; height: 100px;">
                         <td>
                         <div class="icons">
                         <svg class="icon edit" data-id="${product.id}" enable-background="new 0 0 64 64" height="64px" id="Layer_1" version="1.1" viewBox="0 0 64 64" width="64px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                             <g>
                                 <path d="M55.736,13.636l-4.368-4.362c-0.451-0.451-1.044-0.677-1.636-0.677c-0.592,0-1.184,0.225-1.635,0.676l-3.494,3.484   l7.639,7.626l3.494-3.483C56.639,15.998,56.639,14.535,55.736,13.636z" />
                                 <polygon points="21.922,35.396 29.562,43.023 50.607,22.017 42.967,14.39  " />
                                 <polygon points="20.273,37.028 18.642,46.28 27.913,44.654  " />
                                 <path d="M41.393,50.403H12.587V21.597h20.329l5.01-5H10.82c-1.779,0-3.234,1.455-3.234,3.234v32.339   c0,1.779,1.455,3.234,3.234,3.234h32.339c1.779,0,3.234-1.455,3.234-3.234V29.049l-5,4.991V50.403z" />
                             </g>
                         </svg>
                         <svg class="icon delete" data-id="${product.id}" width="96" xmlns="http://www.w3.org/2000/svg" height="96" viewBox="0 0 96 96" xmlns:xlink="http://www.w3.org/1999/xlink">
                             <path d="m24,78c0,4.968 4.029,9 9,9h30c4.968,0 9-4.032 9-9l6-48h-60l6,48zm33-39h6v39h-6v-39zm-12,0h6v39h-6v-39zm-12,0h6v39h-6v-39zm43.5-21h-19.5c0,0-1.344-6-3-6h-12c-1.659,0-3,6-3,6h-19.5c-2.487,0-4.5,2.013-4.5,4.5s0,4.5 0,4.5h66c0,0 0-2.013 0-4.5s-2.016-4.5-4.5-4.5z" />
                         </svg>
                     </div>
                        </td>`;
        tableBody.appendChild(row);
    });
}



