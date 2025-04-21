<?php
//Добавления товара в корзину
    //Запускаем сессию
    session_start();
    //Подгружаем подключение к БД
    require('./../database.php');
    //Получаем через GET-запрос ID товара
    $id_product = $_GET['product'];

    //Задаём глобальную переменную, которая будет хранить строчки из products с дополнительной ячейкой количества
    if (!isset($_SESSION['cart'][$id_product])) {
        $products = $database -> query(
            "SELECT * 
            FROM products
            WHERE id = $id_product"
        );
        $product = mysqli_fetch_assoc($products);
        $_SESSION['cart'][$id_product] = $product;
        $_SESSION['cart'][$id_product]['count'] = 1;
    } else {
        $_SESSION['cart'][$id_product]['count'] += 1;
    }

    //Производим перенаправление
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
    header("Location: $redirect");
    exit();
?>