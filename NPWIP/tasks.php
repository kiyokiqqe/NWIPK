<?php

session_start();
include 'includes/db.php'; // Підключення до бази даних

// Перевірка авторизації
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Отримання ID папки з параметрів GET
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$folder_id = intval($_GET['id']);

// Перевірка, чи форма була надіслана
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];

    // Підготовка SQL-запиту для додавання завдання
    $query = "INSERT INTO tasks (task_name, task_description, status, priority, folder_id, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Перевірка, чи запит підготувався успішно
    if ($stmt === false) {
        die("Помилка підготовки запиту: " . $conn->error);
    }

    // Прив'язка параметрів
    $stmt->bind_param("ssssii", $task_name, $task_description, $status, $priority, $folder_id, $user_id);

    // Виконання запиту
    if ($stmt->execute()) {
        // Перенаправлення на сторінку з папкою після успішного додавання завдання
        header("Location: view_folder.php?id=$folder_id");
        exit;
    } else {
        echo "Помилка додавання завдання: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати завдання в папку</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        
        <h2>Додати нове завдання</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="task_name">Назва завдання</label>
                <input type="text" name="task_name" id="task_name" required>
            </div>
            <div class="form-group">
                <label for="task_description">Опис завдання</label>
                <textarea name="task_description" id="task_description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="status">Статус</label>
                <select name="status" id="status">
                    <option value="Очікує">Очікує</option>
                    <option value="У процесі">У процесі</option>
                    <option value="Завершено">Завершено</option>
                </select>
            </div>
            <div class="form-group">
                <label for="priority">Пріоритет</label>
                <select name="priority" id="priority">
                    <option value="Низький">Низький</option>
                    <option value="Середній">Середній</option>
                    <option value="Високий">Високий</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Додати завдання</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
