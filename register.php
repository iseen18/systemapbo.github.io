<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=restaurant_site', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if (!empty($username) && !empty($password) && !empty($confirm)) {
        if ($password !== $confirm) {
            $error = "Пароли не совпадают.";
        } else {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                $error = "Пользователь с таким логином уже существует.";
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->execute([$username, $hashed]);
                $success = "Регистрация прошла успешно! Теперь вы можете войти.";
            }
        }
    } else {
        $error = "Пожалуйста, заполните все поля.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Регистрация</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .register-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: var(--bg-seashell);
      padding: 40px 16px;
    }
    .register-form {
      background-color: var(--bg-white);
      padding: 40px;
      border-radius: var(--radius-12);
      box-shadow: var(--shadow);
      width: 100%;
      max-width: 450px;
    }
    .register-form h2 {
      text-align: center;
      font-family: var(--fontFamily-forum);
      font-size: var(--fontSize-2);
      margin-bottom: 20px;
      color: var(--text-rich-black-fogra-29);
    }
    .register-form input {
      width: 100%;
      padding: 12px;
      margin-bottom: 16px;
      border: 1px solid var(--border-platinum);
      border-radius: var(--radius-5);
      font-size: var(--fontSize-7);
    }
    .register-form .btn {
      width: 100%;
      justify-content: center;
    }
    .register-form .message {
      text-align: center;
      font-size: var(--fontSize-7);
      margin-bottom: 15px;
    }
    .register-form .message.success {
      color: green;
    }
    .register-form .message.error {
      color: red;
    }
    .register-form .login-link {
      text-align: center;
      margin-top: 20px;
      font-size: var(--fontSize-7);
    }
    .register-form .login-link a {
      color: var(--text-sinopia);
      font-weight: var(--weight-semiBold);
    }
    .register-form .login-link a:hover {
      color: var(--text-rich-black-fogra-29);
    }
  </style>
</head>
<body>

<div class="register-wrapper">
  <form method="POST" class="register-form">
    <h2>Регистрация</h2>

    <?php if ($error): ?>
      <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
      <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <input type="text" name="username" placeholder="Логин" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required>

    <button type="submit" class="btn"><span class="span">Зарегистрироваться</span></button>

    <div class="login-link">
      Уже есть аккаунт? <a href="login.php">Войти</a>
    </div>
  </form>
</div>

</body>
</html>
