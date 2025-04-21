<?php
// Добавление заказа
    //Запускаем сессию  
    session_start();

    // Если корзина не пустая и пользователь вошёл
    if(isset($_SESSION['cart']) and !empty($_SESSION['cart']) and isset($_SESSION['user'])){
        //Подгружаем подключение к БД
        require('../../database.php');

        // Берём сумму из корзины
        $sum=$_SESSION['sum'];

        //Добавление заказа в БД
        mysqli_query(
            $database, 
            "INSERT INTO orders(`price`, id_status)
            VALUES ('$sum', 1)"
        );

        // Получаем идентификатор только что созданного заказа в БД
        $order_id = mysqli_insert_id($database);

        // Привязка к заказу пользователя в БД
        mysqli_query(
            $database, 
            "INSERT INTO users_orders(id_user, id_order)
            VALUES ('".$_SESSION['user']['id']."', '$order_id')"
        );

        // Привязка к заказу товаров в БД
        foreach($_SESSION['cart'] as $product){
            mysqli_query(
                $database, 
                "INSERT INTO products_orders(id_order, id_product, count)
                VALUES ('$order_id', '".$product['id']."', '".$product['count']."')"
            );
        }

        // Очищаем корзину
        unset($_SESSION['cart']);

        //Производим перенаправление в личный кабинет
        header("Location: ../../page.php?page=account");
    }
?>