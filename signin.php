<section class="signin">
    <div class="container">
        <!-- Отцентрованный блок по горизонтали -->
      <div class="row justify-content-center">
        <div class="col-md-4">
          <h2>Вход в аккаунт</h2>
          <?php if(!isset($_SESSION['user'])) { ?>
          <form action="events/signin/signin.php" method="post">
            <div class="form-group">
              <label for="login">Логин</label>
              <input type="text" class="form-control" id="login" name="login" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
              <label for="email">Электронная почта</label>
              <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            </div>
            <div class="form-group last">
              <label for="password">Пароль</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
              <p><?= $_SESSION['message_signin'] ?></p>
              <?php unset($_SESSION['message_signin']) ?>
            </div>
            <button type="submit" class="btn btn-success">Войти</button>
          </form>
          <?php } else { ?>
          <p>Вы уже в аккаунте!</p>
          <?php } ?>
        </div>
      </div>
    </div>
</section>