<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$conn = new mysqli("localhost", "root", "root", "restaurant_site");

$stmt = $conn->prepare("SELECT * FROM reservations WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои бронирования</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <section class="section">
        <div class="container">
            <h2 class="title text-center">Мои бронирования</h2>

            <?php if ($result->num_rows > 0): ?>
                <ul class="bookings-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <b>Дата:</b> <?php echo htmlspecialchars($row['date']); ?>
                            <b>Время:</b> <?php echo htmlspecialchars($row['time']); ?>
                            <b>Гостей:</b> <?php echo htmlspecialchars($row['people']); ?>
                            <b>Имя:</b> <?php echo htmlspecialchars($row['name']); ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-center" style="color: red;">У вас пока нет бронирований.</p>
            <?php endif; ?>

            <br><a href="profile.php" class="btn">Вернуться в профиль</a>
        </div>
    </section>
</body>
</html>
