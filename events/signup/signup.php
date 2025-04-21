<?php
//Регистрация
    //Запускаем сессию  
    session_start();
    //Подгружаем подключение к БД
    require('../../database.php');
    //Забываем сообщение
    unset($_SESSION['message_signup']);

    //Берём данные из POST-запроса
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    //Берём пользователей с таким логином и почтой из БД
    $registered_users=$database -> query(
        "SELECT * 
        FROM users 
        WHERE login = '$login'
        OR email = '$email'"
    );

    // Если такие нашлись
    if(mysqli_num_rows($registered_users) > 0){
        // Выводим сообщение
        $_SESSION['message_signup']='Этот логин или почта заняты!';
        // Перенаправляем на предыдущую страничку
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
        header("Location: $redirect");
        exit();

    // Если такие не нашлись
    } else {
        // И пароли при вводе совпали и они не пустые
        if(($password===$confirm) and !empty($password) and !empty($confirm)){

            //Добавление в БД пользователя
            mysqli_query(
                $database, 
                "INSERT INTO users(login, `password`, email)
                VALUES ('$login', '$password', '$email')"
            );

            //Берём пользователя с таким логином, почтой и паролем из БД
            $current_users = $database -> query("SELECT *
                                                FROM users
                                                WHERE login = '$login'
                                                AND email = '$email'");
            $current_user = mysqli_fetch_assoc($current_users);

            // Если такие нашлись
            if(mysqli_num_rows($current_users) > 0){
                //Добавляем пользователя в сессию
                $_SESSION['user'] = [
                    "id" => $current_user['id'],
                    "login" => $current_user['login'],
                    "email" => $current_user['email'],
                    "is_admin" => $current_user['is_admin']
                ];
                //Переход в кабинет админа или пользователя в зависимости от роли (пока нет)
                if($_SESSION['user']['is_admin']==0){
                    header("Location: ../../page.php?page=account");
                } else {
                    header("Location: ../../page.php?page=account");
                }

            // Если такие не нашлись
            } else {
                // Выводим сообщение
                $_SESSION['message_signup']='Пользователь не смог быть добавлен в базу данных...';
                // Перенаправляем на предыдущию страничку
                $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
                header("Location: $redirect");
                exit();
            }

        // Пароли при вводе не совпали
        } else {
            // Выводим сообщение
            $_SESSION['message_signup']='Пароли не верные!';
            // Перенаправляем на предыдущию страничку
            $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
            header("Location: $redirect");
            exit();
        }
    }
?>