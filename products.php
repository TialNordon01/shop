<?php
    //Запускаем сессию
    session_start();
    //Подключаемся к базе данных
    require_once 'database.php';
    
    // Очистка фильтров
    if (isset($_GET['clear_filter'])) {
        unset($_SESSION['filter']);
    }
    
    //Получаем через запросы параметры фильтрации и кладём их в сессию
    if(isset($_POST['search']))
        $_SESSION['filter']['search'] = $_POST['search'];
    if(isset($_GET['sorting']))
        $_SESSION['filter']['sorting'] = $_GET['sorting'];
    if(isset($_GET['order']))
        $_SESSION['filter']['order'] = $_GET['order'];
    if(isset($_GET['category'])) {
        $_SESSION['filter']['category'] = $_GET['category'];
        // Сбрасываем подкатегорию при смене категории
        unset($_SESSION['filter']['subcategory']);
    }
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
                    href="page.php?page=products&sorting=name&order=asc">
                        Название по возрастанию
                    </a>
                    <a class="btn <?= ($_SESSION['filter']['sorting']=='name' and $_SESSION['filter']['order']=='desc')?'btn-success':'btn-outline-success' ?>" 
                    href="page.php?page=products&sorting=name&order=desc">
                        Название по убыванию
                    </a>
                    <a class="btn <?= ($_SESSION['filter']['sorting']=='price' and $_SESSION['filter']['order']=='asc')?'btn-success':'btn-outline-success' ?>" 
                    href="page.php?page=products&sorting=price&order=asc">
                        Цена по возрастанию
                    </a>
                    <a class="btn <?= ($_SESSION['filter']['sorting']=='price' and $_SESSION['filter']['order']=='desc')?'btn-success':'btn-outline-success' ?>" 
                    href="page.php?page=products&sorting=price&order=desc">
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
                        <li><a class="dropdown-item" href="page.php?page=products&per_page=6">6</a></li>
                        <li><a class="dropdown-item" href="page.php?page=products&per_page=12">12</a></li>
                        <li><a class="dropdown-item" href="page.php?page=products&per_page=18">18</a></li>
                        <li><a class="dropdown-item" href="page.php?page=products&per_page=24">24</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Блок с товарами -->
            <div class="col-md-9 left">
                <?php
                // Получаем условия фильтрации из сессии
                $where_clause = isset($_SESSION['filter']['sql_conditions']) ? $_SESSION['filter']['sql_conditions'] : "";
                $params = isset($_SESSION['filter']['sql_params']) ? $_SESSION['filter']['sql_params'] : [];

                // Формируем SQL-запрос для получения товаров с учетом фильтров
                $sql = "SELECT DISTINCT p.*, c.name as category_name, sc.name as subcategory_name 
                        FROM products p 
                        LEFT JOIN categories c ON p.id_category = c.id 
                        LEFT JOIN products_subcategories ps ON p.id = ps.id_product
                        LEFT JOIN subcategories sc ON ps.id_subcategory = sc.id";

                // Добавляем условия WHERE если они есть
                if (!empty($where_clause)) {
                    $sql .= " " . $where_clause;
                }

                // Добавляем сортировку если она задана
                if(isset($_SESSION['filter']['sorting']) && isset($_SESSION['filter']['order'])) {
                    $sorting = $_SESSION['filter']['sorting'];
                    $order = $_SESSION['filter']['order'];
                    
                    // Проверяем допустимые значения для сортировки
                    $allowed_sorting = ['name', 'price'];
                    $allowed_order = ['asc', 'desc'];
                    
                    if(in_array($sorting, $allowed_sorting) && in_array(strtolower($order), $allowed_order)) {
                        $sql .= " ORDER BY p.$sorting " . strtoupper($order);
                    }
                }

                // Выполняем запрос
                if (!empty($params)) {
                    // Подготавливаем запрос
                    $stmt = $database->prepare($sql);
                    if (!$stmt) {
                        die("Ошибка подготовки запроса: " . $database->error);
                    }
                    
                    // Привязываем параметры
                    $types = str_repeat('i', count($params));
                    $stmt->bind_param($types, ...$params);
                    
                    // Выполняем запрос
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $products = $result->fetch_all(MYSQLI_ASSOC);
                } else {
                    $result = $database->query($sql);
                    if (!$result) {
                        die("Ошибка запроса: " . $database->error);
                    }
                    $products = $result->fetch_all(MYSQLI_ASSOC);
                }

                // Получаем общее количество товаров для пагинации
                $count_sql = "SELECT COUNT(DISTINCT p.id) as total FROM products p 
                            LEFT JOIN categories c ON p.id_category = c.id 
                            LEFT JOIN products_subcategories ps ON p.id = ps.id_product
                            LEFT JOIN subcategories sc ON ps.id_subcategory = sc.id 
                            $where_clause";
                
                if (!empty($params)) {
                    $count_stmt = $database->prepare($count_sql);
                    $count_stmt->bind_param($types, ...$params);
                    $count_stmt->execute();
                    $count_result = $count_stmt->get_result();
                } else {
                    $count_result = $database->query($count_sql);
                }
                
                $total_products = $count_result->fetch_assoc()['total'];
                $products_per_page = isset($_SESSION['filter']['per_page']) ? $_SESSION['filter']['per_page'] : 6;
                $total_pages = $products_per_page > 0 ? ceil($total_products / $products_per_page) : 1;
                $current_page = isset($_SESSION['filter']['number']) ? $_SESSION['filter']['number'] : 1;

                // Добавляем LIMIT для пагинации
                $offset = ($current_page - 1) * $products_per_page;
                $sql .= " LIMIT $offset, $products_per_page";

                // Повторно выполняем запрос с LIMIT
                if (!empty($params)) {
                    $stmt = $database->prepare($sql);
                    $stmt->bind_param($types, ...$params);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $products = $result->fetch_all(MYSQLI_ASSOC);
                } else {
                    $result = $database->query($sql);
                    $products = $result->fetch_all(MYSQLI_ASSOC);
                }

                if (!empty($products)) {
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
                        <a href="page.php?page=products&category=<?= $category['id'] ?>" class="list-group-item list-group-item-action <?= ($category['id'] == $_SESSION['filter']['category']) ? 'active' : '' ?>">
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
                                    <a href="page.php?page=products&subcategory=<?= $subcategory['id'] ?>" class="list-group-item list-group-item-action <?= ($subcategory['id'] == $_SESSION['filter']['subcategory']) ? 'active' : '' ?>">
                                        <?= $subcategory['name'] ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <a href="page.php?page=products&clear_filter=1" class="btn btn-danger">Очистить фильтры</a>
            </div>
        </div>
        <!-- Блок фильтрации по характеристикам -->
        <?php if (isset($_SESSION['filter']['category'])) { ?>
        <div class="row mt-4">
            <div class="col-md-12">
                <h4>Фильтрация по характеристикам</h4>
                <form action="events/products/filter.php" method="get" class="characteristics-filter">
                    <?php
                    // Получаем характеристики для выбранной категории
                    $characteristics_query = "
                        SELECT c.*, pc.value 
                        FROM characteristics c 
                        LEFT JOIN product_characteristics pc ON c.id = pc.id_characteristic 
                        WHERE c.id_category = {$_SESSION['filter']['category']}
                        GROUP BY c.id
                    ";
                    $characteristics = $database->query($characteristics_query);
                    
                    foreach ($characteristics as $characteristic) {
                        // Получаем уникальные значения для характеристики
                        $values_query = "
                            SELECT DISTINCT pc.value 
                            FROM product_characteristics pc 
                            JOIN products p ON pc.id_product = p.id 
                            WHERE pc.id_characteristic = {$characteristic['id']}
                            AND p.id_category = {$_SESSION['filter']['category']}
                        ";
                        $values = $database->query($values_query);
                    ?>
                        <div class="characteristic-group mb-3">
                            <label class="form-label"><?= $characteristic['name'] ?></label>
                            <select name="characteristic_<?= $characteristic['id'] ?>" class="form-select">
                                <option value="">Все</option>
                                <?php while ($value = mysqli_fetch_assoc($values)) { ?>
                                    <option value="<?= $value['value'] ?>" 
                                        <?= (isset($_SESSION['filter']['characteristics'][$characteristic['id']]) 
                                            && $_SESSION['filter']['characteristics'][$characteristic['id']] == $value['value']) 
                                            ? 'selected' : '' ?>>
                                        <?= $value['value'] ?> <?= $characteristic['unit'] ? $characteristic['unit'] : '' ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <button type="submit" class="btn btn-success">Применить фильтры</button>
                </form>
            </div>
        </div>
        <?php } ?>
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
                            <a class="page-link" href="page.php?page=products&number=<?= (isset($_SESSION['filter']['number']))?
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
                                <a class="page-link" href="page.php?page=products&number=<?= $i ?>"> 
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
                                <a class="page-link" href="page.php?page=products&number=<?= $i ?>"> 
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
                                <a class="page-link" href="page.php?page=products&number=<?= $i ?>"> 
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
                                <a class="page-link" href="page.php?page=products&number=<?= $i ?>"> 
                                    <?= $i ?> 
                                </a>
                            </li>
                        <?php
                            }
                        } 
                        ?>
                        <!-- Кнопка "вперёд" -->
                        <li class="page-item">
                            <a class="page-link" href="page.php?page=products&number=<?= (isset($_SESSION['filter']['number']))?
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
<?php } ?>