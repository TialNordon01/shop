<?php
    //Подгружаем подключение к БД
    require('./../database.php');

    // Получаем ID товара из запроса
    $product_id = $_GET['product'];

    // Если текущий пользователь-администратор
    if ($_SESSION['user']['is_admin'] == 1) {
        // Удаляем товар из базы данных
        mysqli_query(
           $database,
           "DELETE FROM products 
            WHERE id = '$product_id'"
        );
    }

    //Производим перенаправление
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
    header("Location: $redirect");
    exit();
?>