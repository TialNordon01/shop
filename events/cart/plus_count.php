<?php
//Прибавление количества
    //Запускаем сессию
    session_start();
    //Получаем через GET-запрос ID товара
    $id_product = $_GET['product'];

    //Прибавляем количество 
    $_SESSION['cart'][$id_product]['count'] += 1;

    //Производим перенаправление
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
    header("Location: $redirect");
    exit();
?>