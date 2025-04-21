<?php
//Убавление количества
    //Запускаем сессию
    session_start();
    //Получаем через GET-запрос ID товара
    $id_product = $_GET['product'];

    //Убавляем количество 
    if($_SESSION['cart'][$id_product]['count']>1){
        $_SESSION['cart'][$id_product]['count'] -= 1;
    } else {
        unset($_SESSION['cart'][$id_product]);
    }
    

    //Производим перенаправление
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
    header("Location: $redirect");
    exit();
?>