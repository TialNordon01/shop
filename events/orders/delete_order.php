<?php
//Удаление заказа
    session_start();
    require('../../database.php');
    
    //Берём данные из GET-запроса
    $order_id = $_GET['order'];
    
    // Если текущий пользователь-администратор
    if ($_SESSION['user']['is_admin'] == 1) {
      // Удаляем заказ из таблицы заказов
      $database -> query(
        "DELETE FROM orders
        WHERE id = '$order_id'"
      );
      
      //и связующей таблицы с товарами
      $database -> query(
        "DELETE FROM users_orders
        WHERE id_order = '$order_id'"
      );
    }
    
    //Перенаправляем на предыдущую страничку
    $redirect = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect");
    exit();
?>