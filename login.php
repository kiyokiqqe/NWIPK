<?php
session_start();
include 'includes/db.php'; // Підключення до бази даних

// Перевірка, чи користувач вже авторизований
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Обробка форми входу
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Підготовка запиту для перевірки логіна
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Зберігаємо ID користувача в сесії
        header("Location: dashboard.php"); // Перенаправлення на кабінет
        exit;
    } else {
        $error = "Невірний логін або пароль!";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вхід</title>
    <link rel="stylesheet" href="css/forlogandreg.css">
</head>
<body>
    <?php include 'includes/header.php'; ?> 

    <div class="login-container">
        <h2>Вхід до системи</h2>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Логін</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Увійти</button>
        </form>

        <p>Ще немає акаунту? <a href="register.php">Зареєструйтесь</a></p>
    </div>
</body>
</html>
