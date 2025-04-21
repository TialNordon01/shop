<section class="signup">
  <div class="container">
    <!-- Отцентрованный блок по горизонтали -->
    <div class="row justify-content-center">
      <div class="col-md-4">
        <h2>Регистрация</h2>
        <?php if(!isset($_SESSION['user'])) { ?>
        <form action="events/signup/signup.php" method="post">
          <div class="form-group">
            <label for="login">Логин</label>
            <input type="text" class="form-control" id="login" name="login" aria-describedby="loginHelp">
          </div>
          <div class="form-group">
            <label for="email">Электронная почта</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <div class="form-group">
            <label for="confirm">Подтверждение пароля</label>
            <input type="password" class="form-control" id="confirm" name="confirm">
          </div>
          <div class="form-group">
            <p><?= $_SESSION['message_signup'] ?></p>
            <?php unset($_SESSION['message_signup'])?>
          </div>
          <button type="submit" class="btn btn-success">Зарегистрироваться</button>
          <?php } else { ?>
          <p>Вы уже в аккаунте!</p>
          <?php } ?>
        </form>
      </div>
    </div>
  </div>
</section>