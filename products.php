<?php
    //Запускаем сессию
    session_start();
    //Получаем через запросы параметры фильтрации и кладём их в сессию
    if(isset($_POST['search']))
        $_SESSION['filter']['search'] = $_POST['search'];
    if(isset($_GET['sorting']))
        $_SESSION['filter']['sorting'] = $_GET['sorting'];
    if(isset($_GET['order']))
        $_SESSION['filter']['order'] = $_GET['order'];
    if(isset($_GET['category']))
        $_SESSION['filter']['category'] = $_GET['category'];
    if(isset($_GET['subcategory']))
        $_SESSION['filter']['subcategory'] = $_GET['subcategory'];
    if(isset($_GET['number']))
        $_SESSION['filter']['number'] = $_GET['number'];
    if (isset($_GET['per_page'])) 
        $_SESSION['filter']['per_page'] = $_GET['per_page'];
?>
<section class="products">
    <div class="container">
        <!-- Блок с поиском -->
        <div class="row">
            <div class="col-md-12 search">
                <form action="events/products/filter.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Название товара" name="search" aria-label="Название товара" aria-describedby="button-addon" value="<?= $_SESSION['filter']['search'] ?>">
                        <button type="submit" class="btn btn-success" id="button-addon"><img src="img/products/magnifying-glass.png" alt="Поиск" height="30px"></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Блок с сортировкой -->
        <div class="row">
            <div class="col-md-9 d-flex justify-content-center sort">
                <div class="btn-group w-100">
                    <a class="btn <?= ($_SESSION['filter']['sorting']=='name' and $_SESSION['filter']['order']=='asc')?'btn-success':'btn-outline-success' ?>" 
                    href="events/products/filter.php?sorting=name&order=asc">
                        Название по возрастанию
                    </a>
                    <a class="btn <?= ($_SESSION['filter']['sorting']=='name' and $_SESSION['filter']['order']=='desc')?'btn-success':'btn-outline-success' ?>" 
                    href="events/products/filter.php?sorting=name&order=desc">
                        Название по убыванию
                    </a>
                    <a class="btn <?= ($_SESSION['filter']['sorting']=='price' and $_SESSION['filter']['order']=='asc')?'btn-success':'btn-outline-success' ?>" 
                    href="events/products/filter.php?sorting=price&order=asc">
                        Цена по возрастанию
                    </a>
                    <a class="btn <?= ($_SESSION['filter']['sorting']=='price' and $_SESSION['filter']['order']=='desc')?'btn-success':'btn-outline-success' ?>" 
                    href="events/products/filter.php?sorting=price&order=desc">
                        Цена по убыванию
                    </a>
                </div>
            </div>
            <!-- Блок с количеством элементов на странице -->
            <div class="col-md-3 d-flex justify-content-center sort">
                <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Количество элементов на странице: <?= $_SESSION['filter']['per_page']?? 6 ?>
                    </button>
                    <ul class="dropdown-menu w-100 dropdown-menu-end">
                        <li><a class="dropdown-item" href="events/products/filter.php?per_page=6">6</a></li>
                        <li><a class="dropdown-item" href="events/products/filter.php?per_page=12">12</a></li>
                        <li><a class="dropdown-item" href="events/products/filter.php?per_page=18">18</a></li>
                        <li><a class="dropdown-item" href="events/products/filter.php?per_page=24">24</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Блок с товарами -->
            <div class="col-md-9 left">
                <?php
                //В зависимости от выбранной категории и подкатегории и страницы формируем запрос
                $products_query = "
                    SELECT DISTINCT id, `name`, price, image 
                    FROM products
                    JOIN products_subcategories 
                    ON products.id = products_subcategories.id_product
                ";
                // Добавляем поисковой запрос если есть
                if (isset($_SESSION['filter']['search']) and !empty($_SESSION['filter']['search'])) {
                    $products_query .= ' WHERE name LIKE "%' . $_SESSION['filter']['search'] . '%"';
                    //потом выбираем категорию
                    if (isset($_SESSION['filter']['category'])) {
                        $id_category = $_SESSION['filter']['category'];
                        $products_query .= " AND id_category = $id_category";
                        //потом подкатегорию
                        if (isset($_SESSION['filter']['subcategory'])) {
                            $id_subcategory = $_SESSION['filter']['subcategory'];
                            $products_query .= " AND id_subcategory = $id_subcategory";
                        }
                    }
                //иначе
                } else {
                    //выбираем категорию
                    if (isset($_SESSION['filter']['category'])) {
                        $id_category = $_SESSION['filter']['category'];
                        $products_query .= " WHERE id_category = $id_category";
                        //потом подкатегорию
                        if (isset($_SESSION['filter']['subcategory'])) {
                            $id_subcategory = $_SESSION['filter']['subcategory'];
                            $products_query .= " AND id_subcategory = $id_subcategory";
                        }
                    }
                }

                // Добавляем фильтры по характеристикам
                if (isset($_SESSION['filter']['stats']) && !empty($_SESSION['filter']['stats'])) {
                    $stats = $_SESSION['filter']['stats'];
                    foreach ($stats as $stat_id => $value) {
                        if (!empty($value)) {
                            $products_query .= " AND EXISTS (
                                SELECT 1 FROM products_stats 
                                WHERE products_stats.id_product = products.id 
                                AND products_stats.id_stat = $stat_id 
                                AND products_stats.value = '$value'
                            )";
                        }
                    }
                }

                //Добавляем сортировку
                if(isset($_SESSION['filter']['sorting']) 
                    and isset($_SESSION['filter']['order']) 
                    and !empty($_SESSION['filter']['sorting']) 
                    and !empty($_SESSION['filter']['order'])){
                    $products_query .= " ORDER BY ".$_SESSION['filter']['sorting']." ".$_SESSION['filter']['order'];
                }

                // Возьмём общее количество товаров
                $products_count = $database->query($products_query);
                $products_count = mysqli_num_rows($products_count);
                // Затем добавим ограничение вывода на странице и в запросе
                $products_per_page = $_SESSION['filter']['per_page']?? 6;
                if (isset($_SESSION['filter']['number'])) {
                    $current_page = $_SESSION['filter']['number'];
                    $start = ($current_page - 1) * $products_per_page;
                    $products_query .= " LIMIT $start, $products_per_page";
                } else {
                    $products_query .= " LIMIT 0, $products_per_page";
                }

                // Добавляем товары из БД
                $products = $database->query($products_query);
                foreach ($products as $product) {
                ?>
                    <div class="card d-flex align-items-center" style="width: 18rem; cursor: pointer;" onclick="location.href='page.php?page=product&product=<?= $product['id'] ?>'">
                        <img src="<?= $product['image'] ?>" class="card-img-top" alt="Картинка товара">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text"><?= $product['price'] ?> ₽</p>
                            <p><a href="events/to_cart.php?product=<?= $product['id'] ?>" class="btn btn-success">Добавить в корзину</a></p>
                            <?php if ($_SESSION['user']['is_admin'] == 1) { ?>
                                <p><a href="events/delete_product.php?product=<?= $product['id']?>" class="btn btn-danger">Удалить товар</a></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- Блок фильтров -->
            <div class="col-md-3 right">
                <h1>Фильтры</h1>
                <!-- Категории -->
                <h4>Категории</h4>
                <div class="list-group">
                    <?php
                    // Добавление категорий из БД
                    $categories = $database->query("SELECT * FROM categories");
                    foreach ($categories as $category) {
                    ?>
                        <a href="events/products/filter.php?category=<?= $category['id'] ?>" class="list-group-item list-group-item-action <?= ($category['id'] == $_SESSION['filter']['category']) ? 'active' : '' ?>">
                            <?= $category['name'] ?>
                        </a>
                    <?php } ?>
                </div>
                <!-- Подкатегории -->
                <div class="tab-content subcategories">
                    <?php
                    // Добавление скрытых блоков с добавляемым классом для их появления 
                    foreach ($categories as $category) {
                    ?>
                        <div id="category" class="tab-pane <?= ($category['id'] == $_SESSION['filter']['category']) ? 'active' : '' ?>">
                            <h4>Подкатегории</h4>
                            <div class="list-group">
                                <?php
                                // Добавление подкатегорий в эти блоки из БД в соответствии с категорией
                                $id_category = $_SESSION['filter']['category'];
                                $subcategories = $database->query(
                                    "SELECT *
                                    FROM subcategories
                                    WHERE id_category = $id_category"
                                );
                                foreach ($subcategories as $subcategory) {
                                ?>
                                    <a href="events/products/filter.php?subcategory=<?= $subcategory['id'] ?>" class="list-group-item list-group-item-action <?= ($subcategory['id'] == $_SESSION['filter']['subcategory']) ? 'active' : '' ?>">
                                        <?= $subcategory['name'] ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- Фильтры по характеристикам -->
                <?php if (isset($_SESSION['filter']['category'])): ?>
                    <form action="events/products/filter.php" method="get">
                        <?php
                        $id_category = $_SESSION['filter']['category'];
                        $stats = $database->query("
                            SELECT DISTINCT stats.id, stats.name, stats.unit, products_stats.value
                            FROM stats
                            JOIN products_stats ON stats.id = products_stats.id_stat
                            JOIN products ON products_stats.id_product = products.id
                            WHERE products.id_category = $id_category
                            ORDER BY stats.name
                        ");
                        
                        $current_stats = [];
                        while ($stat = $stats->fetch_assoc()) {
                            $current_stats[$stat['id']]['name'] = $stat['name'];
                            $current_stats[$stat['id']]['unit'] = $stat['unit'];
                            $current_stats[$stat['id']]['values'][] = $stat['value'];
                        }
                        
                        foreach ($current_stats as $stat_id => $stat):
                            
                        ?>
                            
                            <div class="mb-3">
                                <h4><?= $stat['name'] ?></h4>
                                <select class="form-select" name="stats[<?= $stat_id ?>]">
                                    <option value="">Все</option>
                                    <?php foreach (array_unique($stat['values']) as $value): ?>
                                        <option value="<?= $value ?>" <?= (isset($_SESSION['filter']['stats'][$stat_id]) && $_SESSION['filter']['stats'][$stat_id] == $value) ? 'selected' : '' ?>>
                                            <?= $value ?> <?= $stat['unit'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                        
                        <button type="submit" class="btn btn-success">Применить фильтры</button>
                    </form>
                <?php endif; ?>

                <a href="events/products/clear_filter.php" class="btn btn-danger">Очистить фильтры</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 d-flex justify-content-center">
                <?php
                //Общее число страниц
                $total_pages = ceil($products_count / $products_per_page);
                //Порог вывода страниц (сумарно не считая "..." и стрелочек)
                $threshold = 4;
                //Если больше 1 страницы - выводим пагинацию
                if($total_pages > 1){
                ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php
                        // if(isset($_SESSION['filter']['number'])){
                        ?>
                        <!-- Кнопка "назад" -->
                        <li class="page-item">
                            <a class="page-link" href="events/products/filter.php?number=<?= (isset($_SESSION['filter']['number']))?
                            (($_SESSION['filter']['number']>1)?
                            $_SESSION['filter']['number'] - 1:
                            $_SESSION['filter']['number']):
                            1 ?>" aria-label="Previous">
                                <span aria-hidden="true"><</span>
                            </a>
                        </li>
                        <?php
                        // }
                        // Если общее число страниц меньше чем порог
                        if($total_pages <= $threshold) {
                            for ($i = 1; $i <= $total_pages; $i++) {
                        ?>
                            <!-- Кнопка с ссылкой на страницу -->
                            <li class="page-item <?= 
                            ($_SESSION['filter']['number'] == $i)?'active':
                            ((!isset($_SESSION['filter']['number']) and $i==1)?'active':'') 
                            ?>">
                                <a class="page-link" href="events/products/filter.php?number=<?= $i ?>"> 
                                    <?= $i ?> 
                                </a>
                            </li>
                        <?php 
                            }
                        // Если общее число страниц больше или равно чем порог
                        } else {
                            for ($i = 1; $i <= ceil($threshold/2); $i++) {
                        ?>
                            <!-- Кнопка с ссылкой на страницу -->
                            <li class="page-item <?= 
                            ($_SESSION['filter']['number'] == $i)?'active':
                            ((!isset($_SESSION['filter']['number']) and $i==1)?'active':'') 
                            ?>">
                                <a class="page-link" href="events/products/filter.php?number=<?= $i ?>"> 
                                    <?= $i ?> 
                                </a>
                            </li>
                        <?php } ?>
                            <!-- Кнопка "..." -->
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    ...
                                </a>
                            </li>
                        <?php
                            for ($i = ceil($threshold/2)+1; $i <= $total_pages-floor($threshold/2); $i++) {
                                if($_SESSION['filter']['number']==$i){
                        ?>
                            <!-- Кнопка с ссылкой на страницу -->
                            <li class="page-item <?= 
                            ($_SESSION['filter']['number'] == $i)?'active':
                            ((!isset($_SESSION['filter']['number']) and $i==1)?'active':'') 
                            ?>">
                                <a class="page-link" href="events/products/filter.php?number=<?= $i ?>"> 
                                    <?= $i ?> 
                                </a>
                            </li>
                            <!-- Кнопка "..." -->
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    ...
                                </a>
                            </li>
                        <?php 
                                    break;
                                }
                            } 
                            for ($i = $total_pages-floor($threshold/2)+1; $i <= $total_pages; $i++) {
                        ?>
                            <!-- Кнопка с ссылкой на страницу -->
                            <li class="page-item <?= 
                            ($_SESSION['filter']['number'] == $i)?'active':
                            ((!isset($_SESSION['filter']['number']) and $i==1)?'active':'') 
                            ?>">
                                <a class="page-link" href="events/products/filter.php?number=<?= $i ?>"> 
                                    <?= $i ?> 
                                </a>
                            </li>
                        <?php
                            }
                        } 
                        ?>
                        <!-- Кнопка "вперёд" -->
                        <li class="page-item">
                            <a class="page-link" href="events/products/filter.php?number=<?= (isset($_SESSION['filter']['number']))?
                            (($_SESSION['filter']['number']<$total_pages)?
                            $_SESSION['filter']['number'] + 1:
                            $_SESSION['filter']['number']):
                            2 ?>" aria-label="Next">
                                <span aria-hidden="true">></span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php } ?>
            </div>
        </div>
    </div>
</section>