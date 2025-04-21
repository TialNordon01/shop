<section class="account">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="text-center">Личный кабинет</h2>
        <?php
          if(isset($_SESSION['user'])){
        ?>
        <div class="row">
          <div class="col-md-12 table-responsive">
            <h3>История заказов</h3>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Дата</th>
                  <th>Номер заказа</th>
                  <th>Сумма</th>
                  <th>Статус</th>
                </tr>
              </thead>
              <tbody>
              <?php
              // Добавление заказов на страницу
              $orders = $database -> query(
                "SELECT orders.id, orders.date, orders.price, statuses.name as status 
                FROM orders
                JOIN statuses
                ON orders.id_status = statuses.id
                JOIN users_orders
                ON orders.id = users_orders.id_order
                WHERE id_user = ".$_SESSION['user']['id']
              );
              foreach($orders as $order){
              ?>
              <!-- javascript обработчик для перехода по ссылке -->
              <tr style="cursor: pointer;" onclick="window.location.href='page.php?page=order&order=<?= $order['id']?>';">
                <td><?= $order['date']?></td>
                <td>Заказ #<?= $order['id']?></td>
                <td><?= $order['price']?> ₽</td>
                <td><?= $order['status']?> 
                <?php if($order['status'] == 'В обработке'){?>
                  <a href="events/cancel_order.php?order=<?= $order['id']?>" class="btn btn-danger">Отменить</a>
                <?php }?>
                </td>
              </tr>
              <?php }?>
            </tbody>
            </table>  
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h3>Настройки</h3>
            <h5>Введите новые данные и они сохранятся!</h5>
            <form action="events/account/change_info.php" method="post">
              <div class="form-group">
                <label for="login">Логин</label>
                <input type="text" class="form-control" id="login" name="login" value="<?= $_SESSION['user']['login']?>">
              </div>
              <div class="form-group">
                <label for="email">Электронная почта</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $_SESSION['user']['email']?>">
              </div>
              <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" value="">
              </div>
              <div class="form-group">
                <label for="confirm">Повторить пароль</label>
                <input type="password" class="form-control" id="confirm" name="confirm" value="">
              </div>
              <div class="form-group">
                <p><?= $_SESSION['message_account']?></p>
                <?php unset($_SESSION['message_account'])?>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-success">Сохранить</button>
                <a class="btn btn-danger right" href="events/account/signout.php">Выйти из аккаунта</a>
              </div>
            </form>
          </div>
        </div>
        <?php } else { ?>
          <p class="text-center">Вход не произведён!</p>
        <?php } ?>
      </div>
    </div>
  </div>
</section>