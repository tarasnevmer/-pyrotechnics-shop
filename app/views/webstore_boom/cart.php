<?php
require_once "header.php";
?>
<main class="block-cart">
    <h2>Корзина</h2>
    <div class="basket">
        <?php if (is_array($data['cart'])) : ?>
            <?php foreach ($data['cart'] as $product_in_cart) : ?>
                <div class="product-cart">
                    <h3><?php echo $product_in_cart->name; ?></h3>
                    <img class="image-product" width="160px" height="200px" src="/../pyrotehnic/public/assets/webstore/img/products/<?php echo $product_in_cart->path_image; ?>">
                    <p>Ціна: <?php echo $product_in_cart->price; ?> грн</p>
                    <span>Кількість: </span>
                    <button class="add-count" data-basketid="<?= $product_in_cart->cart_id; ?>">+</button>
                    <input class="input-count" type="text" min="1" data-basketid="<?= $product_in_cart->cart_id; ?>" value="<?php echo $product_in_cart->quantity; ?>">
                    <button class="minus-count" data-basketid="<?= $product_in_cart->cart_id; ?>">-</button>
                    <button class="delete-product" data-basketid="<?= $product_in_cart->cart_id; ?>">Видалити</button>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>У вашій корзині немає товарів.</p>
        <?php endif; ?>
        <br>
        <span class="sum">Загальна сума: <?php echo $data['sum'] ?> грн.</span>
    </div>
    <button>Оформити замовлення</button>
</main>
<?php
require_once "footer.php";
?>
<script src="<?= ASSETS ?>webstore/js/cart.js"></script>