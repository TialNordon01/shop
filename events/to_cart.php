<?php
//Добавления товара в корзину
    //Запускаем сессию
    session_start();
    //Подгружаем подключение к БД
    require('./../database.php');
    //Получаем через GET-запрос ID товара
    $id_product = $_GET['product'];

// Проверяем, есть ли уже такой товар в корзине
if (!isset($_SESSION['cart'][$id_product])) {
    // Если товара нет в корзине, получаем его данные из БД
    $products = $database -> query(
        "SELECT * 
        FROM products
        WHERE id = $id_product"
    );
    // Добавляем товар в корзину с начальным количеством 1
    $product = mysqli_fetch_assoc($products);
    $_SESSION['cart'][$id_product] = $product;
    $_SESSION['cart'][$id_product]['count'] = 1;
} else {
    // Если товар уже есть в корзине, увеличиваем его количество на 1
    $_SESSION['cart'][$id_product]['count'] += 1;
}

    //Производим перенаправление
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
    header("Location: $redirect");
    exit();
?>