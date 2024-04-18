<!DOCTYPE html>
<html lang="en-US">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $data['page_title'] . " | " . WEBSITE_TITLE ?></title>
  <link rel="stylesheet" href="<?= ASSETS ?>webstore/css/header.css">
  <link rel="stylesheet" href="<?= ASSETS ?>webstore/css/footer.css">
  <link rel="stylesheet" href="<?= ASSETS ?>webstore/css/home.css">
  <link rel="stylesheet" href="<?= ASSETS ?>webstore/css/admin_table.css">
  <link rel="stylesheet" href="<?= ASSETS ?>webstore/css/cart.css">
  <link rel="stylesheet" href="<?= ASSETS ?>webstore/css/about.css">
</head>

<body>
  <header>
    <nav>
      <a href="<?= ROOT ?>home" class="logo">
        <img class="logo-before" src="<?= ASSETS ?>webstore/img/logo/logo2.png" alt="">

      </a>
      <div class="top-nav center">
        <ul>
          <li><a href="<?= ROOT ?>home">Головна</a></li>
          <li><a href="<?= ROOT ?>about">Про нас</a></li>
          <li><a href="<?= ROOT ?>contact">Контакти</a></li>
        </ul>
      </div>

      <div class="top-search">
        <input type="text" id="input_search" placeholder="Шукати товари" class="input_search">
      </div>
      <div class="user_nav">
        <?php if (!isset($_SESSION['user_name'])) : ?>
          <li><a href="<?= ROOT ?>login">Увійти</a></li>
          <li><a href="<?= ROOT ?>signup">Зареєструватись</a></li>
        <?php else : ?>
          <li><a href="<?= ROOT ?>logout">Вийти</a></li>
          <li><a href="<?= ROOT ?>cart">Корзина</a></li>
          <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) : ?>
            <li><a href="<?= ROOT ?>admin_table">Адмін-панель</a></li>
          <?php endif; ?>
        <?php endif; ?>
      </div>
      <div class="div_log">
        <?php if (isset($_SESSION['user_name'])) : ?>
          <span class="user_logined"><?= $_SESSION['user_name'] ?></span>
        <?php endif; ?>
      </div>
    </nav>
  </header>