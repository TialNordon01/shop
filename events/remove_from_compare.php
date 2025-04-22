<?php
    session_start();
    
    // Получаем ID товара
    $product_id = isset($_GET['product']) ? (int)$_GET['product'] : 0;
    
    // Удаляем товар из массива сравнения
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
    
    // Перенаправляем обратно на страницу сравнения
    header('Location: page.php?page=compare');
    exit; 
?>