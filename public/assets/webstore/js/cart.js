function updateTotalSum(totalSum) {
    if (totalSum == null)
    {
        totalSum = "";
    }
    document.querySelector(".sum").innerText = "Загальна сума: " + totalSum + " грн.";
}

const deleteButtons = document.querySelectorAll('.delete-product');
deleteButtons.forEach(button => {
    button.addEventListener("click", function () {
        const id = button.dataset.basketid;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "type=delete_product&basket_id=" + id;

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                button.parentElement.remove();
                updateTotalSum(response.sum);
            }
        };

        xhr.send(data);
    })
});


const inputs_count = document.querySelectorAll('.input-count');
inputs_count.forEach(input_count => {
    input_count.addEventListener('change', function () {
        let quantity = parseInt(input_count.value);
        if (isNaN(quantity) || quantity <= 0) {
            input_count.value = '1';
        }
        const id = input_count.dataset.basketid;
        quantity = input_count.value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "type=input_count&input_value=" + quantity + "&basket_id=" + id;
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                updateTotalSum(response.sum);
            }
        };
        xhr.send(data);
    });
});

const btns_add_count = document.querySelectorAll('.add-count');
btns_add_count.forEach(btn_add_count => {
    btn_add_count.addEventListener("click", function () {
        const id = btn_add_count.dataset.basketid;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "type=add_count&basket_id=" + id

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                btn_add_count.parentElement.querySelector('.input-count').value = response.quantity;
                updateTotalSum(response.sum);
            }
        };

        xhr.send(data);
    })
});

const btns_minus_count = document.querySelectorAll('.minus-count');
btns_minus_count.forEach(btn_minus_count => {
    btn_minus_count.addEventListener("click", function () {
        const id = btn_minus_count.dataset.basketid;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "type=minus_count&basket_id=" + id

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.quantity >= 1) {
                    btn_minus_count.parentElement.querySelector('.input-count').value = response.quantity;
                }
                updateTotalSum(response.sum);
            }
        };

        xhr.send(data);
    })
});

