<?php
// Фильтры
    //Запускаем сессию
    session_start();

    //Очищаем фильтры
    unset($_SESSION['filter']);

    //Производим перенаправление на список товаров
    header("Location: ../../page.php?page=products");
?>