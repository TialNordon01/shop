<?php
    //Добавление категории
    session_start();
    require('../../database.php');

    //Берём данные из POST-запроса
    $name = $_POST['name'];

    // Если текущий пользователь-администратор
    if ($_SESSION['user']['is_admin'] == 1) {
        
        // Выбираем из таблицы по заданному имени
        $category = $database -> query(
            "SELECT * FROM categories
            WHERE name = '$name'"
        );
    
        // Если такие нашлись
        if($category->num_rows > 0){
            // Выводим сообщение об ошибке
            $_SESSION['message_add_category'] = 'Категория с таким названием уже существует!';
        
        } else {
            // Добавляем категорию в таблицу
            $database -> query(
              "INSERT INTO categories (name)
              VALUES ('$name')"
            );
        
            // Передаём сообщение об успешном добавлении
            $_SESSION['message_add_category'] = 'Категория добавлена успешно!';
        }
    }

    //Перенаправляем на предыдущую страничку
    $redirect = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect");
    exit();
?>