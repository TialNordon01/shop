<section class="add_subcategory">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2>Добавить подкатегорию</h2>
        <?php if(isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1) {?>
        <form action="events/add_subcategory/add_subcategory.php" method="post">
          <div class="form-group">
            <label for="name">Название подкатегории</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
          </div>
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
          </div>
          <div class="form-group">
            <p><?= $_SESSION['message_add_subcategory']?></p>
            <?php unset($_SESSION['message_add_subcategory'])?>
          </div>
          <button type="submit" class="btn btn-success">Добавить подкатегорию</button>
        </form>
        <?php } else {?>
          <p>Вы не имеете доступа к этой странице!</p>
        <?php }?>
      </div>
    </div>
  </div>
</section>