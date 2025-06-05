<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=restaurant_site', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];

        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: " . $redirect);
        } else {
            header("Location: profile.php");
        }
        exit();
    } else {
        $error = "Неверный логин или пароль";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Вход</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .auth-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: var(--bg-seashell);
      padding: 40px 16px;
    }
    .auth-form {
      background-color: var(--bg-white);
      padding: 40px;
      border-radius: var(--radius-12);
      box-shadow: var(--shadow);
      width: 100%;
      max-width: 450px;
    }
    .auth-form h2 {
      text-align: center;
      font-family: var(--fontFamily-forum);
      font-size: var(--fontSize-2);
      margin-bottom: 20px;
      color: var(--text-rich-black-fogra-29);
    }
    .auth-form input {
      width: 100%;
      padding: 12px;
      margin-bottom: 16px;
      border: 1px solid var(--border-platinum);
      border-radius: var(--radius-5);
      font-size: var(--fontSize-7);
    }
    .auth-form .btn {
      width: 100%;
      justify-content: center;
    }
    .auth-form .error {
      color: red;
      text-align: center;
      margin-bottom: 15px;
    }
    .auth-form .register-link {
      text-align: center;
      margin-top: 20px;
      font-size: var(--fontSize-7);
    }
    .auth-form .register-link a {
      color: var(--text-sinopia);
      font-weight: var(--weight-semiBold);
    }
    .auth-form .register-link a:hover {
      color: var(--text-rich-black-fogra-29);
    }
  </style>
</head>
<body>

  <div class="auth-wrapper">
    <form class="auth-form" method="POST">
      <h2>Вход в аккаунт</h2>

      <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <input type="text" name="username" placeholder="Логин" required>
      <input type="password" name="password" placeholder="Пароль" required>

      <button type="submit" class="btn"><span class="span">Войти</span></button>

      <div class="register-link">
        Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
      </div>
    </form>
  </div>

</body>
</html>
