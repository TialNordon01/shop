<?php
//Удаление товара из корзины
    //Запускаем сессию
    session_start();
    //Получаем через GET-запрос ID товара
    $id_product = $_GET['product'];

    //Забываем одну строчку из корзины 
    unset($_SESSION['cart'][$id_product]);

    //Производим перенаправление
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
    header("Location: $redirect");
    exit();
?>