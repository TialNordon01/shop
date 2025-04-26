<?php
    // Получаем ID товаров из сессии
    $compare_products = isset($_SESSION['compare']) ? $_SESSION['compare'] : [];
    // Получаем информацию о товарах
    $products = [];
    if (!empty($compare_products)) {
        // Функция implode объединяет элементы массива $compare_products в строку, 
        // разделяя их запятыми. Это нужно для формирования списка ID товаров 
        // для SQL-запроса с оператором IN. Например, если в массиве $compare_products 
        // есть значения [1, 3, 5], то $ids будет равно "1,3,5"
        $ids = implode(',', $compare_products);
        $query = "SELECT products.*, categories.name as category_name 
                  FROM products 
                  LEFT JOIN categories ON products.id_category = categories.id 
                  WHERE products.id IN ($ids)";
        $result = mysqli_query($database, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }

    // Получаем характеристики для каждого товара
    // Создаем новый массив для хранения товаров с их характеристиками
    $products_with_stats = [];
    foreach ($products as $product) {
        $query = "SELECT stats.name, products_stats.value 
                  FROM products_stats 
                  JOIN stats ON products_stats.id_stat = stats.id 
                  WHERE products_stats.id_product = {$product['id']}";
        $result = mysqli_query($database, $query);
        $product['stats'] = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $product['stats'][$row['name']] = $row['value'];
        }
        $products_with_stats[] = $product;
    }
    // Заменяем исходный массив на новый с характеристиками
    $products = $products_with_stats;
?>

<section class="compare">
    <div class="container">
        <h2 class="text-center mb-4">Сравнение товаров</h2>
        
        <?php if (isset($_SESSION['message_compare'])): ?>
            <div class="alert alert-info text-center">
                <?= $_SESSION['message_compare'] ?>
                <?php unset($_SESSION['message_compare']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($products)): ?>
            <div class="alert alert-info text-center">
                <p>Вы еще не добавили товары для сравнения</p>
                <a href="page.php?page=products" class="btn btn-success">Перейти к товарам</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Характеристика</th>
                            <?php foreach ($products as $product): ?>
                                <th class="text-center">
                                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>" style="max-height: 150px; object-fit: contain;">
                                    <h5 class="mt-2"><?= $product['name'] ?></h5>
                                    <p class="text-success"><?= number_format($product['price'], 2, '.', ' ') ?> ₽</p>
                                    <a href="page.php?page=product&product=<?= $product['id'] ?>" class="btn btn-outline-success btn-sm">Подробнее</a>
                                    <a href="events/remove_from_compare.php?product=<?= $product['id'] ?>" class="btn btn-outline-danger btn-sm">Удалить</a>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Категория</td>
                            <?php foreach ($products as $product): ?>
                                <td class="text-center"><?= $product['category_name'] ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php
                        // Собираем все уникальные характеристики
                        $all_stats = [];
                        foreach ($products as $product) {
                            foreach ($product['stats'] as $name => $value) {
                                $all_stats[$name] = true;
                            }
                        }
                        // Выводим характеристики
                        foreach ($all_stats as $name => $value):
                        ?>
                            <tr>
                                <td><?= $name ?></td>
                                <?php foreach ($products as $product): ?>
                                    <td class="text-center"><?= isset($product['stats'][$name]) ? $product['stats'][$name] : '-' ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>