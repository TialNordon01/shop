<section class="product">
    <div class="container">
    <!-- Отцентрованный блок по вертикали -->
      <div class="row d-flex align-items-center justify-content-center">
        <?php
        if(isset($_GET['product']) and !empty($_GET['product'])){
            $id_product = $_GET['product'];
            $products = $database -> query(
                "SELECT products.id AS id,
                        products.name AS product_name,
                        price,
                        image,
                        categories.name AS category_name,
                        subcategories.name AS subcategory_name,
                        description
                FROM products
                JOIN categories ON products.id_category = categories.id
                JOIN products_subcategories ON products.id = products_subcategories.id_product
                JOIN subcategories ON products_subcategories.id_subcategory = subcategories.id
                WHERE products.id = $id_product"
              );
            $product = mysqli_fetch_assoc($products);
        ?>
        <!-- Блок с картинкой товара -->
        <div class="col-md-5 left text-center">
          <img src="<?= $product["image"] ?>" class="img-fluid" alt="Товар">
        </div>
        <!-- Блок с описанием товара -->
        <div class="col-md-7 right">
          <h2><?= $product["product_name"] ?></h2>
          <h5>Цена: <?= $product["price"] ?> ₽</h5>
          <p>Категория: <?= $product["category_name"] ?></p>
          <p>
            Подкатегории: <br>
            <?php
              foreach($products as $subcategory){
                echo $subcategory["subcategory_name"]."<br>";
              }
            ?>
          </p>
          <p>
            Описание: <br>
            <?= $product["description"] ?>
          </p>
          <a class="btn btn-success" href="events/to_cart.php?product=<?= $id_product ?>" role="button">Добавить в корзину</a>
          <?php if ($_SESSION['user']['is_admin'] == 1) { ?>
          <a href="events/delete_product.php?product=<?= $product['id']?>" class="btn btn-danger">Удалить товар</a>
          <?php } ?>
        </div>
        <?php } else { ?>
          <h1>Товар не определён...</h1>
        <?php } ?>
      </div>
    </div>
</section>