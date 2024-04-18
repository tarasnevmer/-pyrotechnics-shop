<?php
require_once "header.php";
?>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<div class="btnAddAndCategory">
    <button id="btnAddProduct">Додати товар</button>
    <select id="get-category-products">
        <option value="">Всі</option>
        <option value="Петарди">Петарди</option>
        <option value="Феєрверк">Феєрверк</option>
        <option value="Бенгальські вогні">Бенгальські вогні</option>
    </select>
</div>
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <label>Назва продукта:</label>
        <input type="text" id="name">

        <label>Ціна:</label>
        <input type="text" id="price">

        <label>Категорія:</label>
        <select id="category">
            <option value="Петарди">Петарди</option>
            <option value="Феєрверк">Феєрверк</option>
            <option value="Бенгальські вогні">Бенгальські вогні</option>
        </select>

        <label>Країна:</label>
        <input type="text" id="country">

        <label>Кількість в упаковці:</label>
        <input type="text" id="count">

        <label>Опис:</label>
        <textarea id="description"></textarea>

        <label>Шлях до зображення:</label>
        <input type="text" id="path_image">

        <div class="buttons">
            <button id="btnSubmitAddProduct">Додати</button>
            <button id="btnCloseModal">Закрити</button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#btnAddProduct").click(function() {
            $("#addProductModal").css("display", "block");
        });

        $("#btnCloseModal").click(function() {
            $("#addProductModal").css("display", "none");
        });

        $("#btnSubmitAddProduct").click(function() {
            $("#addProductModal").css("display", "none");
        });
    });
</script>
<div id="editProductModal" class="modal">
    <div class="modal-content">

        <label>Назва продукта:</label>
        <input type="text" id="name_edit">

        <label>Ціна:</label>
        <input type="text" id="price_edit">

        <label>Категорія:</label>
        <select id="category_edit">
            <option value="Петарди">Петарди</option>
            <option value="Феєрверк">Феєрверк</option>
            <option value="Бенгальські вогні">Бенгальські вогні</option>
        </select>

        <label>Країна:</label>
        <input type="text" id="country_edit">

        <label>Кількість в упаковці:</label>
        <input type="text" id="count_edit">

        <label>Опис:</label>
        <textarea id="description_edit"></textarea>

        <label>Шлях до зображення:</label>
        <input type="text" id="path_image_edit">
        <div class="buttons">
            <button id="btnSubmitEditProduct" onclick="editProduct()">Редагувати</button>
            <button id="btnCloseEditModal">Закрити</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#btnCloseEditModal").click(function() {
            $("#editProductModal").css("display", "none");
        });

        $("#btnSubmitEditProduct").click(function() {
            $("#editProductModal").css("display", "none");
        });
    });
</script>
<div class="table-container">
    <table id="adminTable">
        <thead class="adminTable background-primary text-white">
            <tr>
                <th>Id</th>
                <th>Назва</th>
                <th>Опис</th>
                <th>Ціна</th>
                <th>Кількість</th>
                <th>Країна</th>
                <th>Категорія</th>
                <th>Зображення</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            <?php if (is_array($data['products'])) : ?>
                <?php foreach ($data['products'] as $product) : ?>
                    <tr>
                        <td><?php echo $product->id; ?></td>
                        <td><?php echo $product->name; ?></td>
                        <td class="description"><?php echo $product->description; ?></td>
                        <td><?php echo "$product->price" . " грн."; ?></td>
                        <td><?php echo "$product->count" . " шт." ?></td>
                        <td><?php echo $product->country; ?></td>
                        <td><?php echo $product->category; ?></td>

                        <td><?php echo '<img src="/../pyrotehnic/public/assets/webstore/img/products/' . $product->path_image . '" style="width: 100px; height: 100px;">'; ?></td>
                        <td>
                            <div class="icons">
                                <svg class="icon edit" data-id="<?php echo $product->id; ?>" enable-background="new 0 0 64 64" height="64px" id="Layer_1" version="1.1" viewBox="0 0 64 64" width="64px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g>
                                        <path d="M55.736,13.636l-4.368-4.362c-0.451-0.451-1.044-0.677-1.636-0.677c-0.592,0-1.184,0.225-1.635,0.676l-3.494,3.484   l7.639,7.626l3.494-3.483C56.639,15.998,56.639,14.535,55.736,13.636z" />
                                        <polygon points="21.922,35.396 29.562,43.023 50.607,22.017 42.967,14.39  " />
                                        <polygon points="20.273,37.028 18.642,46.28 27.913,44.654  " />
                                        <path d="M41.393,50.403H12.587V21.597h20.329l5.01-5H10.82c-1.779,0-3.234,1.455-3.234,3.234v32.339   c0,1.779,1.455,3.234,3.234,3.234h32.339c1.779,0,3.234-1.455,3.234-3.234V29.049l-5,4.991V50.403z" />
                                    </g>
                                </svg>
                                <svg class="icon delete" data-id="<?php echo $product->id; ?>" xmlns="http://www.w3.org/2000/svg" height="96" viewBox="0 0 96 96" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path d="m24,78c0,4.968 4.029,9 9,9h30c4.968,0 9-4.032 9-9l6-48h-60l6,48zm33-39h6v39h-6v-39zm-12,0h6v39h-6v-39zm-12,0h6v39h-6v-39zm43.5-21h-19.5c0,0-1.344-6-3-6h-12c-1.659,0-3,6-3,6h-19.5c-2.487,0-4.5,2.013-4.5,4.5s0,4.5 0,4.5h66c0,0 0-2.013 0-4.5s-2.016-4.5-4.5-4.5z" />
                                </svg>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="<?= ASSETS ?>webstore/js/admin_table.js"></script>

<?php
require_once "footer.php"
?>