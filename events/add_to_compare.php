<?php
    // Добавление товара в список сравнения
    session_start();

    // Инициализация массива сравнения, если не существует
    if (!isset($_SESSION['compare'])) {
        $_SESSION['compare'] = [];
    }

    // Ограничение максимального количества сравниваемых товаров
    $max_compare = 4;

    // Получение ID добавляемого товара из GET-параметра
    $product_id = isset($_GET['product']) ? (int)$_GET['product'] : 0;

    // Проверка наличия товара в списке сравнения
    if (in_array($product_id, $_SESSION['compare'])) {
        $_SESSION['message_compare'] = 'Товар уже добавлен для сравнения';
    } elseif (count($_SESSION['compare']) >= $max_compare) {
        $_SESSION['message_compare'] = 'Можно сравнить не более ' . $max_compare . ' товаров';
    } else {
        // Добавляем ID товара в массив сравнения
        $_SESSION['compare'][] = $product_id;
        unset($_SESSION['message_compare']);
    }

    // Перенаправление на предыдущую страницу
    $redirect = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect");
    exit(); 
?>
