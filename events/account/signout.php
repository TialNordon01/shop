<?php
// Выход из аккаунта
    //Запускаем сессию  
    session_start();
    //Забываем пользователя
    unset($_SESSION['user']);
    // Перенаправляем на главную страницу
    header("Location: ../../page.php?page=index");
?>