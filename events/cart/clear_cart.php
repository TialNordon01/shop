<?php
//Очистка корзины
    //Запускаем сессию
    session_start();

    //Забываем про корзину
    unset($_SESSION['cart']);

    //Производим перенаправление
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
    header("Location: $redirect");
    exit();
?>