<?php
// Фильтры
    //Запускаем сессию
    session_start();
    require_once '../../database.php';

    // Очищаем предыдущие фильтры характеристик
    if (isset($_SESSION['filter']['characteristics'])) {
        unset($_SESSION['filter']['characteristics']);
    }

    // Получаем все параметры фильтров из GET-запроса
    foreach ($_GET as $key => $value) {
        if (strpos($key, 'characteristic_') === 0 && !empty($value)) {
            $characteristic_id = substr($key, strlen('characteristic_'));
            $_SESSION['filter']['characteristics'][$characteristic_id] = $value;
        }
    }

    // Формируем SQL-запрос с учетом фильтров
    $where_conditions = [];
    $params = [];

    if (isset($_SESSION['filter']['category'])) {
        $where_conditions[] = "p.id_category = ?";
        $params[] = $_SESSION['filter']['category'];
    }

    if (isset($_SESSION['filter']['subcategory'])) {
        $where_conditions[] = "p.id_subcategory = ?";
        $params[] = $_SESSION['filter']['subcategory'];
    }

    if (isset($_SESSION['filter']['characteristics'])) {
        foreach ($_SESSION['filter']['characteristics'] as $characteristic_id => $value) {
            $where_conditions[] = "EXISTS (
                SELECT 1 FROM product_characteristics pc 
                WHERE pc.id_product = p.id 
                AND pc.id_characteristic = ? 
                AND pc.value = ?
            )";
            $params[] = $characteristic_id;
            $params[] = $value;
        }
    }

    $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

    // Сохраняем условия фильтрации в сессии
    $_SESSION['filter']['sql_conditions'] = $where_clause;
    $_SESSION['filter']['sql_params'] = $params;

    // Перенаправляем обратно на страницу продуктов
    header("Location: ../../products.php");
    exit();
?>