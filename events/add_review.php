<?php
session_start();
require('../database.php');

if (!isset($_SESSION['user'])) {
  header('Location: ../login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product_id = $_POST['product_id'];
  $rating = $_POST['rating'];
  $text = $_POST['review'];
  $user_id = $_SESSION['user']['id'];

  // Добавляем отзыв в таблицу сomments
  $database->query(
    "INSERT INTO сomments (star_count, `text`, id_user) 
     VALUES ($rating, '$text', $user_id)"
  );

  // Получаем id добавленного отзыва
  $comment_id = mysqli_insert_id($database);

  // Связываем отзыв с товаром в таблице products_comments
  $database->query(
    "INSERT INTO products_comments (id_product, id_comment) 
     VALUES ($product_id, $comment_id)"
  );

  //Перенаправляем на предыдущую страничку
  $redirect = $_SERVER['HTTP_REFERER'];
  header("Location: $redirect");
  exit(); 
} else {
  header('Location: ../page.php?page=index');
  exit();
} 