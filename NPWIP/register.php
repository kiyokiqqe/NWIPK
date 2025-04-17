<?php
session_start();
include 'includes/db.php'; // Підключення до бази даних

// Перевірка, чи користувач вже авторизований
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Обробка форми реєстрації
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Будь ласка, заповніть всі поля!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Некоректний email!";
    } elseif ($password !== $confirm_password) {
        $error = "Паролі не співпадають!";
    } else {
        // Перевірка чи існує користувач з таким логіном або email
        $query = "SELECT id FROM users WHERE username = :username OR email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        
        if ($stmt->rowCount() === 0) {
            // Хешування пароля
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Додавання користувача в базу
            $insert_query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $insert_stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $insert_stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
            
            if ($insert_stmt->execute()) {
                $_SESSION['user_id'] = $conn->lastInsertId();
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Помилка реєстрації!";
            }
        } else {
            $error = "Користувач з таким логіном або email вже існує!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>
    <link rel="stylesheet" href="css/forlogandreg.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="register-container">
        <h2>Реєстрація</h2>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Логін</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Підтвердження пароля</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Зареєструватись</button>
        </form>

        <p>Маєте акаунт? <a href="login.php">Увійдіть</a></p>
    </div>
</body>
</html>
