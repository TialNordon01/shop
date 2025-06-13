<?php
    // Удаление товара из списка сравнения
    session_start();

    // Получение ID удаляемого товара из GET-параметра
    $product_id = isset($_GET['product']) ? (int)$_GET['product'] : 0;

    // Удаление товара из массива сравнения по ID
    if (isset($_SESSION['compare'])) {
        $key = array_search($product_id, $_SESSION['compare']);
        if ($key !== false) {
            unset($_SESSION['compare'][$key]);
            $_SESSION['compare'] = array_values($_SESSION['compare']);
            $_SESSION['message'] = 'Товар удален из сравнения';
        } else {
            $_SESSION['message'] = 'Товар не найден в списке сравнения';
        }
    }

    // Перенаправление на предыдущую страницу
    $redirect = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect");
    exit(); 
?>
