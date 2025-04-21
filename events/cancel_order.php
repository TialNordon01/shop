<?php
//Отмена заказа 
    //Подгружаем подключение к БД
    require('./../database.php');
    // Обновление статуса заказа
    $order_id = $_GET['order'];
    $database -> query(
        "UPDATE orders 
        SET id_status = 3 
        WHERE id = $order_id"
    );
    //Производим перенаправление в личный кабинет
    header("Location: ../page.php?page=account");
?>