<?php
//Изменение данных статуса заказа в системе
    //Запускаем сессию
    session_start();
    //Подгружаем подключение к БД
    require('../../database.php');
    
    //Берём данные из GET-запроса
    $order_id = $_GET['order'];
    $status_id = $_GET['status'];

    // Если текущий пользователь-администратор
    if ($_SESSION['user']['is_admin'] == 1) {
        //Обновляем статус заказа в БД
        $database -> query(
            "UPDATE orders
            SET id_status = '$status_id'
            WHERE id = '$order_id'"
        );
    }
    
    //Перенаправляем на предыдущую страничку
    $redirect = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect");
    exit();
?>