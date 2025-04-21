<?php
    //Добавление подкатегории
    session_start();
    require('../../database.php');

    //Берём данные из POST-запроса
    $name = $_POST['name'];
    $category_id = $_POST['category'];

    // Если текущий пользователь-администратор
    if ($_SESSION['user']['is_admin'] == 1) {

      // Выбираем из таблицы по заданному имени и категории
      $subcategories = $database -> query(
        "SELECT * FROM subcategories
        WHERE name = '$name' AND id_category = '$category_id'"
      );

      // Если такие нашлись
      if($subcategories->num_rows > 0){
        // Выводим сообщение об ошибке
        $_SESSION['message_add_subcategory'] = 'Подкатегория с таким названием уже существует в этой  категории!';
      } else {
        // Добавляем подкатегорию в таблицу
        $database -> query(
          "INSERT INTO subcategories (name, id_category)
          VALUES ('$name', '$category_id')"
        );
        // Передаём сообщение об успешном добавлении
        $_SESSION['message_add_subcategory'] = 'Подкатегория добавлена успешно!';
      }

    }

    //Перенаправляем на предыдущую страничку
    $redirect = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect");
    exit();
?>