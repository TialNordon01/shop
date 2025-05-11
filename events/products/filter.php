<?php
// Фильтры
    //Запускаем сессию
    session_start();
    //Получаем через запросы параметры фильтрации и кладём их в сессии
    if(isset($_POST['search']))
        $_SESSION['filter']['search'] = $_POST['search'];
    if(isset($_GET['sorting']))
        $_SESSION['filter']['sorting'] = $_GET['sorting'];
    if(isset($_GET['order']))
        $_SESSION['filter']['order'] = $_GET['order'];
    if(isset($_GET['category'])){
        $_SESSION['filter']['category'] = $_GET['category'];
        unset($_SESSION['filter']['subcategory']);
        unset($_SESSION['filter']['stats']);
    }
    if(isset($_GET['subcategory']))
        $_SESSION['filter']['subcategory'] = $_GET['subcategory'];
    if(isset($_GET['number'])){
        $_SESSION['filter']['number'] = $_GET['number'];
    } else {
        unset($_SESSION['filter']['number']);
    }
    if (isset($_GET['per_page'])) 
        $_SESSION['filter']['per_page'] = $_GET['per_page'];
    if(isset($_GET['stats'])) {
        $_SESSION['filter']['stats'] = $_GET['stats'];
    }

    //Производим перенаправление на список товаров
    header("Location: ../../page.php?page=products");
?>