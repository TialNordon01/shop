<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин бытовой техники</title>
    <link rel="icon" href="img/shop.png" type="image/png">
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <header class="header">
      <!-- Навигационная панель -->
      <nav class="navbar navbar-expand-lg bg-success" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="page.php"><img src="img\header\home.png" alt="Магазин" height="30px"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav left me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link <?= ($page == 'index' or !isset($page))? 'active' : ''?>" aria-current="page" href="page.php?page=index">Главная</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= ($page == 'categories')? 'active' : ''?>" href="page.php?page=categories">Категории</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= ($page == 'products')? 'active' : ''?>" href="page.php?page=products">Список товаров</a>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link disabled">Отключенная</a>
              </li> -->
            </ul>
            <!-- <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Поиск">
              <button class="btn btn-outline-success" type="submit">Поиск</button>
            </form> -->
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1){?>
              <a class="btn btn-info" href="page.php?page=orders" role="button">Заказы</a>
              <a class="btn btn-info" href="page.php?page=add_product" role="button">Добавить товар</a>
              <a class="btn btn-info" href="page.php?page=add_category" role="button">Добавить категорию</a>
              <a class="btn btn-info" href="page.php?page=add_subcategory" role="button">Добавить подкатегорию</a>
            <?php }?>
            <?php if(isset($_SESSION['user'])){ ?>
              <a class="btn btn-success <?= ($page == 'account')? 'active' : ''?>" href="page.php?page=account"><?= $_SESSION['user']['login'] ?></a>
            <?php } ?>
            <?php if(isset($_SESSION['user'])){ ?>
              <a class="btn btn-link" href="page.php?page=account" role="button"><img src="img\header\profile.png" alt="Личный кабинет" height="30px"></a>
            <?php } ?>
            <a class="btn btn-link" href="page.php?page=cart" role="button"><img src="img\header\cart.png" alt="Корзина" height="30px"></a>
            <a class="btn btn-link" href="page.php?page=compare" role="button"><img src="img\header\compare.png" alt="Сравнение" height="30px"></a>
            <?php if(!isset($_SESSION['user'])){ ?>
            <div class="navbar-nav right">
              <a class="btn btn-outline-light ms-2" href="page.php?page=signup" role="button">Зарегистрироватся</a>
              <a class="btn btn-outline-light ms-2" href="page.php?page=signin" role="button">Войти</a>
            </div>
            <?php } ?>
          </div>
        </div>
      </nav>
    </header>
