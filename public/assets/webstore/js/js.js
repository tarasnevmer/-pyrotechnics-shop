
// add AJAX
const add_btn = document.getElementById("btnSubmitAddProduct");

add_btn.addEventListener("click", function (event) {
    event.preventDefault();

    // Отримуємо значення полів форми
    var name = document.getElementById("name").value;
    var price = document.getElementById("price").value;
    var category = document.getElementById("category").value;
    var country = document.getElementById("country").value;
    var count = document.getElementById("count").value;
    var description = document.getElementById("description").value;
    var path_image = document.getElementById("path_image").value;

    // Виконуємо AJAX-запит для перевірки даних на сервері
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true);

    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Створюємо рядок даних для відправки
    var data = "name=" + encodeURIComponent(name) + "&price=" + encodeURIComponent(price) + "&category=" + encodeURIComponent(category) + "&country=" +
        encodeURIComponent(country) + "&count=" + encodeURIComponent(count) +
        "&description=" + encodeURIComponent(description) + "&path_image=" + encodeURIComponent(path_image) + "&type=add_product";

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var responseData = JSON.parse(xhr.responseText);
            updateTable(responseData);


            // Очищення значень інпутів після успішної відправки
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

    // Відправляємо AJAX-запит
    xhr.send(data);
});


document.addEventListener("DOMContentLoaded", function () {
    // Отримуємо батьківський елемент таблиці
    var tableBody = document.querySelector("#adminTable tbody");

    // Додаємо подію для батьківського елемента таблиці
    tableBody.addEventListener("click", function (event) {
        // Перевіряємо, чи була натискана кнопка видалення
        if (event.target.classList.contains("delete-btn")) {
            var id = event.target.getAttribute("data-id");
            // Викликайте функцію для видалення товару з productId
            deleteProduct(id);
        }
    });
});


function openModalEditWindow(id) {
    window.history.pushState({}, '', '?id=' + id);

    $("#editProductModal").css("display", "block");
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


            console.log('Response:', xhr.responseText);

            window.history.replaceState({}, document.title, window.location.pathname);
            //location.reload()
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

            // Очищення значень інпутів після успішної відправки
            console.log('Response:', xhr.responseText);
        }
    };


    // Відправляємо AJAX-запит
    xhr.send(data2);
}



function updateTable(data) {
    var tableBody = document.querySelector("#adminTable tbody");
    tableBody.innerHTML = "";

    data.forEach(function (product) {
        var row = document.createElement("tr");
        row.innerHTML = `<td>${product.id}</td>
                         <td>${product.name}</td>
                         <td>${product.description}</td>
                         <td>${product.price} грн.</td>
                         <td>${product.count} шт.</td>
                         <td>${product.country}</td>
                         <td>${product.category}</td>
                         <td><img src="/../pyrotehnic/public/assets/webstore/img/${product.path_image}" style="width: 100px; height: 100px;">
                         <td>
                            <button class="edit-btn" data-id="${product.id}">Редагувати</button>
                            <button class="delete-btn" data-id=${product.id}">Видалити</button>
                        </td>`;
        tableBody.appendChild(row);
    });
}



