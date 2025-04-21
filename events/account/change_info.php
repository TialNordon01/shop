<?php
//Редактирование данных пользователя
    //Запускаем сессию  
    session_start();
    //Подгружаем подключение к БД
    require('./../database.php');
    //Забываем сообщение
    unset($_SESSION['message_account']);

    //Берём данные из POST-запроса
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    //Берём пользователей с таким логином и почтой, исключая текущего пользователя, из БД
    $registered_users=$database -> query(
        "SELECT * 
        FROM users 
        WHERE (login = '$login' OR email = '$email')
        AND id != ".$_SESSION['user']['id']
    );
    $registered_user = mysqli_fetch_assoc($registered_users);

    // Если такие нашлись
    if((mysqli_num_rows($registered_users) > 0)){
        // Выводим сообщение
        $_SESSION['message_account']='Этот логин занят!';
        // Перенаправляем на предыдущую страничку
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
        header("Location: $redirect");
        exit();

    // Если такие не нашлись
    } else {
        // И пароли при вводе совпали
        if(($password===$confirm) and !empty($password) and !empty($confirm)){

            //Изменение в БД пользователя
            mysqli_query(
                $database, 
                "UPDATE users
                SET login = '$login',
                    email = '$email',
                    `password` = '$password'
                WHERE id = ".$_SESSION['user']['id']
            );

            //Берём пользователя с таким логином и паролем из БД
            $current_users = $database -> query(
                "SELECT *
                FROM users
                WHERE login = '$login'
                AND email = '$email'"
            );
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
                // Выводим сообщение
                $_SESSION['message_account']='Изменение успешно!';
                // Перенаправляем на предыдущию страничку
                $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
                header("Location: $redirect");
                exit();

            // Если такие не нашлись
            } else {
                // Выводим сообщение
                $_SESSION['message_account']='Пользователь не смог быть изменён в базе данных...';
                // Перенаправляем на предыдущию страничку
                $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
                header("Location: $redirect");
                exit();
            }

        // Пароли при вводе не совпали
        } else {
            // Выводим сообщение
            $_SESSION['message_account']='Пароли не верные!';
            // Перенаправляем на предыдущию страничку
            $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'redirect-form.html';
            header("Location: $redirect");
            exit();
        }
    }
?>