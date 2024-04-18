<?php
require_once "header.php"
?>
<main role="main" class="main">
  <article class="home-products">
    <select name="category" id="products-category">
      <option value = "">Каталог товарів</option>
      <option value="Петарди">Петарди</option>
      <option value="Феєрверк">Феєрверк</option>
      <option value="Бенгальські вогні">Бенгальські вогні</option>
    </select>
    <div class="container-products">
      <div class="products">
        <?php if (is_array($data['products'])) : ?>
          <?php foreach ($data['products'] as $product) : ?>
            <div class="product font-size-14 font-family">
              <div class="image-product"><img src="/../pyrotehnic/public/assets/webstore/img/products/<?php echo $product->path_image; ?>"></div>
              <div class="text-product">
                <span class="name"><?php echo "$product->category" . " $product->name";  ?></span>
                <span class="count"><?php echo "в упаковці " . $product->count . " шт."; ?></span>
                <span class="price"><?php echo $product->price . ' грн.'; ?></span>
                <button class="btn-add-cart" data-id="<?= $product->id ?>">У кошик</button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </article>
  <br>
</main>

<?php
require_once "footer.php"
?>
<script src="<?= ASSETS ?>webstore/js/home.js"></script>