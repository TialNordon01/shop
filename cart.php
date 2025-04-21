<section class="cart">
  <div class="container">
    <!-- Отцентрированный блок по горизонтали -->
    <div class="row justify-content-center">
      <div class="col-md-10 table-responsive">
        <h2>Корзина</h2>
        <!-- Таблица корзины -->
        <table class="table table-hover">
          <thead>
            <tr>
              <th></th>
              <th>Товар</th>
              <th>Количество</th>
              <th>Цена</th>
              <th>Сумма</th>
              <th><a class="btn btn-secondary" href="events/cart/clear_cart.php">Очистить</a></th>
            </tr>
          </thead>
          <tbody>
            <!-- Товары в корзине будут отображаться здесь -->
             <?php
                // Сумма для итоговой цены заказа
                $sum = 0;
                // Если корзина не пуста, добавляем товары
                if(isset($_SESSION['cart']) and !empty($_SESSION['cart'])){
                  foreach($_SESSION['cart'] as $product){
             ?>
              <tr style="cursor: pointer;" onclick="window.location.href='page.php?page=product&product=<?= $product['id'] ?>';">
                <td><img src="<?= $product['image'] ?>" alt="Картинка товара" height="150px"></td>
                <td><?= $product['name'] ?></td>
                <td><?= $product['count'] ?> <a class="btn btn-secondary" href="events/cart/plus_count.php?product=<?= $product['id'] ?>">+</a> <a class="btn btn-secondary" href="events/cart/minus_count.php?product=<?= $product['id'] ?>">-</a></td>
                <td><?= $product['price'] ?> ₽</td>
                <td><?= $product['count'] * $product['price'] ?> ₽</td>
                <td><a class="btn btn-danger" href="events/cart/from_cart.php?product=<?= $product['id'] ?>">Удалить</a></td>
              </tr>
            <?php 
                $sum += $product['count'] * $product['price'];
                // Добавляем сумму заказа в глобальную переменную
                $_SESSION['sum']=$sum;
                } 
              } else {
            ?>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><p>Корзина пуста!</p></td>
                <td></td>
                <td></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <!-- Блок снизу -->
        <div class="row">
          <div class="col-md-8">
          <?php if(!isset($_SESSION['user'])){ ?>
            <h4 class="alert">Зарегистрируйтесь, чтобы оформить заказ!</h4>
          <?php } ?>
          </div>
          <div class="col-md-4">
            <h4>Итого: <?= $sum ?> ₽</h4>
            <a class="btn btn-success <?= (!isset($_SESSION['cart']) or empty($_SESSION['cart']) or !isset($_SESSION['user'])) ? 'disabled" aria-disabled="true"' : "" ?>" href="events/cart/add_order.php">Оформить заказ</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>