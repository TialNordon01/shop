<section class="add_product">
    <div class="container">
      <!-- Отцентрованный блок по горизонтали -->
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h2>Добавить товар</h2>
          <?php if(isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1) {?>
          <!-- Форма товара -->
          <form action="events/add_product/add_product.php" method="post" enctype="multipart/form-data">
            <!-- Название -->
            <div class="form-group">
              <label for="name">Название товара</label>
              <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
            </div>
            <!-- Категория -->
            <div class="form-group">
              <label for="category">Категория</label>
              <select class="form-control" id="category" name="category">
                <option value="">Выберите категорию...</option>
                <?php 
                  $categories = $database -> query("SELECT * FROM categories");
                  foreach($categories as $category){
               ?>
                <option value="<?= $category['id']?>"><?= $category['name']?></option>
                <?php }?>
              </select>
              <a href="page.php?page=add_category" class="btn btn-success">Добавить категорию</a>
            </div>
            <!-- Подкатегория -->
            <div class="form-group">
              <label for="subcategory">Подкатегория</label>
              <select class="form-control" id="subcategory" name="subcategory">
                <option value="">Выберите подкатегорию...</option>
                <?php 
                  $subcategories = $database -> query("SELECT * FROM subcategories");
                  foreach($subcategories as $subcategory){
               ?>
                <option value="<?= $subcategory['id']?>"><?= $subcategory['name']?></option>
                <?php }?>
              </select>
              <a href="page.php?page=add_subcategory" class="btn btn-success">Добавить подкатегорию</a>
            </div>
            <!-- Цена -->
            <div class="form-group">
              <label for="price">Цена</label>
              <input type="number" class="form-control" id="price" name="price">
            </div>
            <!-- Описание товара -->
            <div class="form-group">
              <label for="description">Описание товара</label>
              <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <!-- Фото товара -->
            <div class="form-group">
              <label for="image">Фото товара</label>
              <input type="file" class="form-control" id="image" name="image">
            </div>
            <!-- Сообщение -->
            <div class="form-group">
              <p><?= $_SESSION['message_add_product']?></p>
              <?php unset($_SESSION['message_add_product'])?>
            </div>
            <button type="submit" class="btn btn-success">Добавить товар</button>
          </form>
          <?php } else {?>
            <p>Вы не имеете доступа к этой странице!</p>
          <?php }?>
        </div>
      </div>
    </div>
</section>