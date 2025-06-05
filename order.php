<?php
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'order.php';
    header('Location: login.php');
    exit();
}

// Подключение к базе данных
$pdo = new PDO('mysql:host=localhost;dbname=restaurant_site;charset=utf8mb4', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_text = trim($_POST['order_text']);
    $user_id = $_SESSION['user_id'];

    if (!empty($order_text)) {
        $stmt = $pdo->prepare("INSERT INTO user_orders (user_id, order_text) VALUES (?, ?)");
        $stmt->execute([$user_id, $order_text]);

        header('Location: user_orders.php');
        exit();
    } else {
        $error = "Пожалуйста, введите заказ.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Оформление заказа</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .order-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 40px 16px;
      background-color: var(--bg-seashell);
    }
    .order-form {
      max-width: 500px;
      background-color: var(--bg-white);
      padding: 40px;
      border-radius: var(--radius-12);
      box-shadow: var(--shadow);
      width: 100%;
    }
    .order-form h2 {
      font-family: var(--fontFamily-forum);
      font-size: var(--fontSize-2);
      margin-bottom: 20px;
      color: var(--text-rich-black-fogra-29);
      text-align: center;
    }
    .order-form textarea {
      width: 100%;
      height: 150px;
      padding: 15px;
      font-size: var(--fontSize-7);
      border: 1px solid var(--border-platinum);
      border-radius: var(--radius-5);
      resize: none;
      margin-bottom: 20px;
    }
    .order-form .error {
      color: red;
      margin-bottom: 10px;
      text-align: center;
    }
    .order-form .btn {
      width: 100%;
      justify-content: center;
    }
    .back-home {
      margin-top: 20px;
      display: inline-block;
      text-align: center;
      color: var(--text-sinopia);
      font-weight: var(--weight-semiBold);
    }
    .back-home:hover {
      color: var(--text-rich-black-fogra-29);
    }
  </style>
</head>
<body>

  <div class="order-wrapper">
    <form class="order-form" method="POST">
      <h2>Сделать заказ</h2>

      <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <textarea name="order_text" placeholder="Введите ваш заказ..." required></textarea>
      <button type="submit" class="btn"><span class="span">Отправить заказ</span></button>
      <a class="back-home" href="index.html">← Вернуться на главную</a>
    </form>
  </div>

</body>
</html>
