<?php
//Вход
    //Запускаем сессию  
    session_start();
    //Подгружаем подключение к БД
    require('../../database.php');
    //Забываем сообщение
    unset($_SESSION['message_signin']);

    //Берём данные из POST-запроса
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Берём пользователя с таким логином, почтой и паролем из БД
    $users = $database -> query(
        "SELECT *
        FROM users
        WHERE login = '$login'
        AND email = '$email'
        AND `password` = hashing('$password')"
    );
    
    // Если не нашло таких пользователя
    if(mysqli_num_rows($users) == 0){
        // Выводим сообщение
        $_SESSION['message_signin']='Неверные данные!';
        // Перенаправляем на предыдущую страничку
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
        header("Location: $redirect");
        exit();
    // Если нашло пользователя
    } else {
        //Добавляем пользователя в сессию
        $user = mysqli_fetch_assoc($users);
        $_SESSION['user'] = [
            "id" => $user['id'],
            "login" => $user['login'],
            "email" => $user['email'],
            "is_admin" => $user['is_admin']
        ];
        //Переход в кабинет админа или пользователя в зависимости от роли (пока нет)
        if($_SESSION['user']['is_admin']==0){
            header("Location: ../../page.php?page=account");
        } else {
            header("Location: ../../page.php?page=account");
        }
    }
    
?>