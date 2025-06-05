<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=restaurant_site', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$username = $user ? htmlspecialchars($user['username']) : 'Пользователь';
echo "<p style='text-align:center;margin-top:20px;'>Вы вошли как: <strong>$username</strong></p>";
?>



<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Личный кабинет</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .profile-container {
      max-width: 600px;
      margin: 40px auto;
      padding: 30px;
      background-color: #fff;
      border-radius: 20px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      text-align: center;
    }
    .profile-title {
      font-size: 28px;
      margin-bottom: 10px;
    }
    .profile-welcome {
      font-size: 18px;
      color: #666;
      margin-bottom: 30px;
    }
    .profile-actions .btn {
      display: block;
      width: 100%;
      margin: 10px 0;
      padding: 12px;
      font-size: 16px;
      border-radius: 12px;
    }
    @media (min-width: 480px) {
      .profile-actions .btn {
        display: inline-block;
        width: auto;
        margin: 10px 15px;
      }
    }
  </style>
</head>
<body>
  <section class="section">
    <div class="profile-container">
      <h2 class="profile-title">Личный кабинет</h2>
      <p class="profile-welcome">Добро пожаловать, <strong><?php echo htmlspecialchars($username); ?></strong>!</p>

      <div class="profile-actions">
        <a href="user_bookings.php" class="btn">📅 Мои бронирования</a>
        <a href="user_orders.php" class="btn">🛒 Мои заказы</a>
        <a href="logout.php" class="btn">🚪 Выйти</a>
      </div>
    </div>
  </section>

  <div style="text-align:center; margin-top: 30px;">
    <a href="index.html" class="btn" style="display:inline-block;">
      <span class="span">← На главный экран</span>
    </a>
  </div>
</body>

</html>
