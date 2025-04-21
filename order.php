<section class="order">
  <div class="container">
    <div class="row justify-content-center">
      <?php if(isset($_GET['order']) and !empty($_GET['order'])) {?>
      <div class="col-md-10 table-responsive">
        <h2 class="text-center">Содержание заказа #<?= $_GET['order']?></h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th></th>
              <th>Название товара</th>
              <th>Цена</th>
              <th>Количество</th>
              <th>Сумма</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $order_id = $_GET['order'];
              $products = $database -> query(
                "SELECT products.id, products.image, products.name, products.price, products_orders.count, products.price * products_orders.count as sum
                FROM products
                JOIN products_orders ON products.id = products_orders.id_product
                WHERE products_orders.id_order = $order_id"
              );
              $total_sum = 0;
              foreach ($products as $product) {
                $total_sum += $product['sum'];
        ?>
            <tr style="cursor: pointer;" onclick="window.location.href='page.php?page=product&product=<?= $product['id']?>';">
              <td><img src="<?= $product['image']?>" alt="Картинка товара" height="150px"></td>  
              <td><?= $product['name']?></td>
              <td><?= $product['price']?> ₽</td>
              <td><?= $product['count']?></td>
              <td><?= $product['sum']?> ₽</td>
            </tr>
            <?php }?>
            <tr>
              <td colspan="4">Итого:</td>
              <td><?= $total_sum?> ₽</td>
            </tr>
          </tbody>
        </table>
        <?php 
          $status = $database -> query(
            "SELECT statuses.name 
            FROM statuses
            JOIN orders
            ON orders.id_status = statuses.id
            WHERE orders.id = $order_id"
          );
          $status = mysqli_fetch_assoc($status);
       ?>
        <p>Статус заказа: <?= $status['name']?></p>
        
      </div>
      <div class="row justify-content-center">
        <div class="col-md-10 bottom">
            <a class="btn btn-success" href="page.php?page=account">Назад</a>
            <?php if($status['name'] == 'В обработке'){?>
              <a class="btn btn-danger" href="events/cancel_order.php?order=<?= $order_id ?>">Отменить заказ</a>
            <?php }?>
        </div>
      </div>
      <?php } else {?>
        <h2 class="text-center">Заказ не указан...</h2>
      <?php }?>
    </div>
  </div>
</section>