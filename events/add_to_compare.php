<?php
    session_start();

    // Инициализация массива сравнения, если его нет
    if (!isset($_SESSION['compare'])) {
        $_SESSION['compare'] = [];
    }

    // Максимальное количество товаров для сравнения
    $max_compare = 4;

    // Получаем ID товара
    $product_id = isset($_GET['product']) ? (int)$_GET['product'] : 0;

    // Проверяем, не добавлен ли уже товар
    if (in_array($product_id, $_SESSION['compare'])) {
        $_SESSION['message_compare'] = 'Товар уже добавлен для сравнения';
    } elseif (count($_SESSION['compare']) >= $max_compare) {
        $_SESSION['message_compare'] = 'Можно сравнить не более ' . $max_compare . ' товаров';
    } else {
        // Добавляем ID товара в массив сравнения
        $_SESSION['compare'][] = $product_id;
        unset($_SESSION['message_compare']);
    }

    //Перенаправляем на предыдущую страничку
    $redirect = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect");
    exit(); 
?>