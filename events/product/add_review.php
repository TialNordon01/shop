<?php
// Добавление отзыва о товаре
// Запускаем сессию для работы с данными пользователя
session_start();
require('../../database.php');

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
  header('Location: ../../login.php');
  exit();
}

// Проверяем, что запрос пришел методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Получаем данные из формы
  $product_id = $_POST['product_id'];
  $rating = $_POST['rating'];
  $text = $_POST['review'];
  $user_id = $_SESSION['user']['id'];

  // Добавляем отзыв в таблицу reviews
  // Сохраняем оценку, текст отзыва и ID пользователя
  $database->query(
    "INSERT INTO reviews (star_count, `text`, id_user) 
     VALUES ($rating, '$text', $user_id)"
  );

  // Получаем ID только что добавленного отзыва
  $review_id = mysqli_insert_id($database);

  // Связываем отзыв с товаром в таблице products_reviews
  $database->query(
    "INSERT INTO products_reviews (id_product, id_review) 
     VALUES ($product_id, $review_id)"
  );

  // Устанавливаем сообщение об успешном добавлении отзыва
  $_SESSION['message_review'] = 'Отзыв успешно добавлен';

  // Перенаправляем пользователя на страницу товара
  $redirect = $_SERVER['HTTP_REFERER'];
  header("Location: $redirect");
  exit(); 
} else {
  // Если запрос не POST, перенаправляем на главную страницу
  header('Location: ../../page.php?page=index');
  exit();
} 