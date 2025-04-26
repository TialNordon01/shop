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
          <a class="btn btn-outline-success" href="events/add_to_compare.php?product=<?= $id_product ?>" role="button">Добавить к сравнению</a>
          <?php if ($_SESSION['user']['is_admin'] == 1) { ?>
          <a href="events/delete_product.php?product=<?= $product['id']?>" class="btn btn-danger">Удалить товар</a>
          <?php } ?>
        </div>

        <!-- Секция отзывов -->
        <div class="col-12 mt-5">
          <h3>Отзывы</h3>
          
          <!-- Форма добавления отзыва -->
          <?php if (isset($_SESSION['user'])) { ?>
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Оставить отзыв</h5>
              <form action="events/product/add_review.php" method="POST">
                <input type="hidden" name="product_id" value="<?= $id_product ?>">
                <div class="mb-3">
                  <label for="rating" class="form-label">Оценка</label>
                  <select class="form-select" id="rating" name="rating" required>
                    <option value="5">5 звезд</option>
                    <option value="4">4 звезды</option>
                    <option value="3">3 звезды</option>
                    <option value="2">2 звезды</option>
                    <option value="1">1 звезда</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="review" class="form-label">Текст отзыва</label>
                  <textarea class="form-control" id="review" name="review" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить отзыв</button>
              </form>
            </div>
          </div>
          <?php } else { ?>
            <div class="alert alert-info">
              <a href="login.php">Войдите</a>, чтобы оставить отзыв
            </div>
          <?php } ?>

          <!-- Список отзывов -->
          <?php
          $reviews = $database->query(
            "SELECT reviews.id, reviews.star_count, reviews.text, reviews.id_user, users.login
             FROM reviews
             JOIN users ON reviews.id_user = users.id
             JOIN products_reviews ON reviews.id = products_reviews.id_review
             WHERE products_reviews.id_product = $id_product
             ORDER BY reviews.id DESC"
          );

          if (mysqli_num_rows($reviews) > 0) {
            while ($review = mysqli_fetch_assoc($reviews)) {
          ?>
            <div class="card mb-3">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="card-title mb-0"><?= $review['login'] ?></h5>
                  <div class="text-warning">
                    <?php for ($i = 0; $i < $review['star_count']; $i++) { ?>
                      <i class="fas fa-star"></i>
                    <?php } ?>
                  </div>
                </div>
                <p class="card-text"><?= $review['text'] ?></p>
              </div>
            </div>
          <?php
            }
          } else {
          ?>
            <div class="alert alert-info">
              Пока нет отзывов. Будьте первым, кто оставит отзыв!
            </div>
          <?php } ?>
        </div>

        <?php } else { ?>
          <h1>Товар не определён...</h1>
        <?php } ?>
      </div>
    </div>
</section>