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
        $_SESSION['message'] = 'Товар уже добавлен для сравнения';
    } elseif (count($_SESSION['compare']) >= $max_compare) {
        $_SESSION['message'] = 'Можно сравнить не более ' . $max_compare . ' товаров';
    } else {
        $_SESSION['compare'][] = $product_id;
        $_SESSION['message'] = 'Товар добавлен для сравнения';
    }

    // Перенаправляем обратно на страницу товара
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit; 
?>