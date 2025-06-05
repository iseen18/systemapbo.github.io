<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = 'reservation.php';
    header('Location: login.php');
    exit();
}

$pdo = new PDO('mysql:host=localhost;dbname=restaurant_site', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$user_id = $_SESSION['user_id'];
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $date = $_POST["date"];
    $time = $_POST["time"];
    $table_number = $_POST["table_number"];
    $people = $_POST["people"];

    if ($name && $date && $time && $table_number && $people) {
        $stmt = $pdo->prepare("INSERT INTO reservations (user_id, name, date, time, table_number, people) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $name, $date, $time, $table_number, $people]);
        $success = "Бронирование успешно создано!";
    } else {
        $error = "Пожалуйста, заполните все поля.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Бронирование столика</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .reservation-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: var(--bg-seashell);
      padding: 40px 16px;
    }
    .reservation-form {
      background-color: var(--bg-white);
      padding: 40px;
      border-radius: var(--radius-12);
      box-shadow: var(--shadow);
      width: 100%;
      max-width: 600px;
    }
    .reservation-form h2 {
      font-family: var(--fontFamily-forum);
      font-size: var(--fontSize-2);
      text-align: center;
      color: var(--text-rich-black-fogra-29);
      margin-bottom: 20px;
    }
    .reservation-form input {
      width: 100%;
      padding: 12px;
      margin-bottom: 16px;
      border: 1px solid var(--border-platinum);
      border-radius: var(--radius-5);
      font-size: var(--fontSize-7);
    }
    .reservation-form .btn {
      width: 100%;
      justify-content: center;
    }
    .reservation-form .message {
      text-align: center;
      font-size: var(--fontSize-7);
      margin-bottom: 15px;
    }
    .reservation-form .message.success {
      color: green;
    }
    .reservation-form .message.error {
      color: red;
    }
  </style>
</head>
<body>

<div class="reservation-wrapper">
  <form method="POST" class="reservation-form">
    <h2>Забронировать столик</h2>

    <?php if ($success): ?>
      <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
      <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <input type="text" name="name" placeholder="Ваше имя" required>
    <input type="date" name="date" required>
    <input type="time" name="time" required>
    <input type="number" name="table_number" placeholder="Номер стола" required>
    <input type="number" name="people" placeholder="Количество человек" required>

    <button type="submit" class="btn"><span class="span">Забронировать</span></button>
  
    <a href="profile.php" class="btn" style="margin-top: 16px; display: block; text-align: center;">
      <span class="span">← Вернуться в профиль</span>
    </a>

  </form>
</div>

</body>
</html>
