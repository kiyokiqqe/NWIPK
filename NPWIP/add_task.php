<?php 
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$folder_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$folder_id) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = trim($_POST['task_name'] ?? '');
    $task_description = trim($_POST['task_description'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $priority = trim($_POST['priority'] ?? '');
    $deadline = $_POST['deadline'] ?? null;

    if ($task_name && $task_description && $status && $priority) {
        $stmt = $conn->prepare("INSERT INTO tasks (task_name, task_description, status, priority, deadline, folder_id, user_id) VALUES (:task_name, :task_description, :status, :priority, :deadline, :folder_id, :user_id)");
        if ($stmt->execute(compact('task_name', 'task_description', 'status', 'priority', 'deadline', 'folder_id', 'user_id'))) {
            header("Location: view_folder.php?id=$folder_id");
            exit;
        } else {
            $error = "Помилка при створенні завдання.";
        }
    } else {
        $error = "Усі поля, крім дедлайну, є обов'язковими.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Нове завдання</title>
    <link rel="stylesheet" href="css/viewtasks.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h2>Створення завдання</h2>
        <?php if (!empty($error)) echo "<p class='error'>" . htmlspecialchars($error) . "</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Назва завдання:</label>
                <input type="text" name="task_name" required>
            </div>
            <div class="form-group">
                <label>Опис:</label>
                <textarea name="task_description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label>Статус:</label>
                <select name="status">
                    <option>Очікує</option>
                    <option>У процесі</option>
                    <option>Завершено</option>
                </select>
            </div>
            <div class="form-group">
                <label>Пріоритет:</label>
                <select name="priority">
                    <option>Низький</option>
                    <option>Середній</option>
                    <option>Високий</option>
                </select>
            </div>
            <div class="form-group">
                <label>Дедлайн (опціонально):</label>
                <input type="date" name="deadline">
            </div>
           <button type="submit" class="btn-submit">Додати завдання</button>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>