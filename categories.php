<section class="categories">
  <div class="container">
    <div class="row">
      <!-- Блок с категориями -->
      <div class="col-md-3">
        <h4>Категории</h4>
        <div class="list-group">
          <?php 
            // Добавление категорий из БД
            $categories = $database -> query("SELECT * FROM categories"); 
            foreach($categories as $category){
          ?>
          <a href="page.php?page=categories&category=<?= $category['id'] ?>" class="list-group-item list-group-item-action <?= ($category['id'] == $_GET['category']) ? 'active' : ''?>">
            <?= $category['name'] ?>
          </a>
          <?php } ?>
        </div>
      </div>
      <!-- Блок с подкатегориями -->
      <div class="col-md-9 subcategories">
        <div class="tab-content">
          <?php 
            // Добавление скрытых блоков с добавляемым классом для их появления
            foreach($categories as $category){ 
          ?>
          <div id="category" class="tab-pane <?= ($category['id'] == $_GET['category']) ? 'active' : ''?>">
            <h4>Подкатегории</h4>
            <div class="list-group">
              <?php 
                // Добавление подкатегорий в эти блоки из БД в соответствии с категорией
                $id_category = $_GET['category'];
                $subcategories = $database -> query(
                    "SELECT *
                    FROM subcategories
                    WHERE id_category = $id_category"
                );
                foreach($subcategories as $subcategory){ 
              ?>
                <a href="page.php?page=products&category=<?= $subcategory['id_category'] ?>&subcategory=<?= $subcategory['id'] ?>" class="list-group-item list-group-item-action">
                  <?= $subcategory['name'] ?>
                </a>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>