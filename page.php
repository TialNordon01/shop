<?php
    //Запускаем сессию
    session_start();
    //Получаем через GET-запрос название страницы
    $page=$_GET['page'];

    //Подгрузка подключения к БД
    require('database.php');
    //Подгрузка шапки
    require('header.php');
    //Подгрузка содержимого
    if(!isset($page) or $page=='index'){
        // Главная
        require('index.php');
    } if($page=='categories') {
        // Категории
        require('categories.php');
    } if($page=='products') {
        // Список товаров
        require('products.php');
    } if($page=='product') {
        // Страница товара
        require('product.php');
    } if($page=='cart') {
        // Корзина
        require('cart.php');
    } if($page=='signin') {
        // Вход
        require('signin.php');
    } if($page=='signup') {
        // Регистрация
        require('signup.php');
    } if($page=='account') {
        // Личный кабинет
        require('account.php');
    } if($page=='order') {
        // Страница заказа
        require('order.php');
    } if($page=='orders') {
        // Все заказы
        require('orders.php');
    } if($page=='add_product') {
        // Добавление товара
        require('add_product.php');
    } if($page=='add_category') {
        // Добавление категории
        require('add_category.php');
    } if($page=='add_subcategory') {
        // Добавление подкатегории
        require('add_subcategory.php');
    }
    //Подгрузка подвала
    require('footer.php');
?>