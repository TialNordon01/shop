<section class="add_category">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2>Добавить категорию</h2>
        <?php if(isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1) {?>
        <form action="events/add_category/add_category.php" method="post">
          <div class="form-group">
            <label for="name">Название категории</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <p><?= $_SESSION['message_add_category']?></p>
            <?php unset($_SESSION['message_add_category'])?>
          </div>
          <button type="submit" class="btn btn-success">Добавить категорию</button>
        </form>
        <?php } else {?>
          <p>Вы не имеете доступа к этой странице!</p>
        <?php }?>
      </div>
    </div>
  </div>
</section>