<?php 
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folder_name = trim($_POST['folder_name'] ?? '');
    
    if ($folder_name !== '') {
        $stmt = $conn->prepare("INSERT INTO folders (user_id, folder_name) VALUES (:user_id, :folder_name)");
        if ($stmt->execute(['user_id' => $user_id, 'folder_name' => $folder_name])) {
            header("Location: dashboard.php?success=folder_created");
            exit;
        }
        $error = "Помилка створення папки.";
    } else {
        $error = "Назва папки не може бути порожньою.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Створити папку</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h2>Нова папка</h2>
        <?php if (!empty($error)) echo "<p class='error'>" . htmlspecialchars($error) . "</p>"; ?>
        <form method="POST">
            <label>Назва: <input type="text" name="folder_name" required></label>
            <button type="submit">Додати</button>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>