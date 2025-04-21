<?php
    //Добавление товара
    session_start();
    require('../../database.php');

    //Берём данные из POST-запроса
    $name = $_POST['name'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Если текущий пользователь-администратор
    if ($_SESSION['user']['is_admin'] == 1) {
      //Загрузка изображения
      $image = $_FILES['image'];
      $image_name = $image['name'];
      $image_tmp = $image['tmp_name'];
      $image_type = $image['type'];

      //Проверяем тип изображения
      if($image_type == 'image/jpeg' || $image_type == 'image/png' || $image_type == 'image/gif'){
        //Получаем название категории
        $category_name = $database -> query(
          "SELECT name 
          FROM categories 
          WHERE id = '$category'"
        );
        $category_name = $category_name->fetch_assoc();
        $category_name = $category_name['name'];

        //Получаем название файла, которое соответствует названию товара
        $file_name = str_replace(array(',', '.', ':', ';', '?', '!', '/'),' ', $name);

        //Перемещаем изображение в папку images
        $image_path = 'img/products/'. $category_name. '/'. $file_name. '.'. pathinfo($image_name, PATHINFO_EXTENSION);
        move_uploaded_file($image_tmp, $image_path);

        //Выполняем запрос на добавление товара
        $product = $database -> query(
          "SELECT * 
          FROM products
          WHERE name = '$name' 
          AND id_category = '$category'"
        );

        //Если товар с таким названием и категорией уже существует, то выводим сообщение об ошибке
        if($product->num_rows > 0){
          $_SESSION['message_add_product'] = 'Товар с таким названием уже существует!';
        } else {
          //Если товара с таким названием нет, то добавляем его в базу данных
          $database -> query(
            "INSERT INTO products (name, id_category, price, image, description)
            VALUES ('$name', '$category', '$price', '$image_path', '$description')"
          );

          //Получаем идентификатор последнего добавленного товара
          $product_id = $database -> insert_id;

          //Добавляем товар в таблицу products_subcategories
          $database -> query(
            "INSERT INTO products_subcategories (id_product, id_subcategory)
            VALUES ('$product_id', '$subcategory')"
          );

          //Передаём сообщение об успешном добавлении
          $_SESSION['message_add_product'] = 'Товар добавлен успешно!';
        }
      } else {
        //Если тип изображения не соответствует требуемому, то выводим сообщение об ошибке
        $_SESSION['message_add_product'] = 'Тип изображения не соответствует требуемому!';
      }
    }

    //Перенаправляем на предыдущую страничку
    $redirect = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect");
    exit();
?>