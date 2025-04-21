<section class="orders">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 table-responsive">
        <h2 class="text-center">Все заказы</h2>
        <?php if(isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1) {?>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Дата</th>
              <th>Номер заказа</th>
              <th>Пользователь</th>
              <th>Сумма</th>
              <th>Статус</th>
              <th>Действия</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $orders = $database -> query(
                "SELECT orders.id, orders.date, orders.price, statuses.name as status, statuses.id as status_id, users.login 
                FROM orders
                JOIN statuses
                ON orders.id_status = statuses.id
                JOIN users_orders
                ON orders.id = users_orders.id_order
                JOIN users
                ON users_orders.id_user = users.id"
              );
              foreach($orders as $order){
          ?>
            <tr>
              <td><?= $order['date']?></td>
              <td>Заказ #<?= $order['id']?></td>
              <td><?= $order['login']?></td>
              <td><?= $order['price']?> ₽</td>
              <td>
                <div class="dropdown">
                  <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= $order['status']?>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-dark">
                    <?php 
                      $statuses = $database -> query("SELECT * FROM statuses");
                      foreach($statuses as $status){
                   ?>
                    <li><a class="dropdown-item" href="events/orders/change_status.php?order=<?= $order['id']?>&status=<?= $status['id']?>"><?= $status['name']?></a></li>
                    <?php }?>
                  </ul>
                </div>
              </td>
              <td>
                <a href="page.php?page=order&order=<?= $order['id']?>" class="btn btn-success">Подробнее</a>
                <a href="events/orders/delete_order.php?order=<?= $order['id']?>" class="btn btn-danger">Удалить</a>
              </td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
      <?php } else {?>
        <p>Вы не имеете доступа к этой странице!</p>
      <?php }?>
    </div>
  </div>
</section>