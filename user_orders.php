<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$conn = new mysqli("localhost", "root", "root", "restaurant_site");

if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT order_text, created_at FROM user_orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои заказы</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h2 class="title text-center">Мои заказы</h2>

            <?php if ($result->num_rows > 0): ?>
                <ul class="bookings-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <b>Дата:</b> <?= htmlspecialchars($row['created_at']) ?><br>
                            <b>Заказ:</b> <?= nl2br(htmlspecialchars($row['order_text'])) ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-center" style="color: red;">У вас пока нет заказов.</p>
            <?php endif; ?>

            <br><a href="profile.php" class="btn">Назад в профиль</a>
        </div>
    </section>
</body>
</html>
