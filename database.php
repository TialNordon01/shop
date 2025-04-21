<?php
    // Подключение к БД

    // Исходные данные
    $host = '127.0.0.1:3306';
    $user = 'root';
    $password = 'root';
    $database_name = 'shop';

    // Соединение
    $database = mysqli_connect($host, $user, $password, $database_name);
    $database -> set_charset('utf8');

?>