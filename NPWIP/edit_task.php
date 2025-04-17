<?php

session_start();
include 'includes/db.php'; 

// Перевірка авторизації
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Перевірка ID завдання
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$task_id = intval($_GET['id']);

// Отримання даних завдання
$query = "SELECT * FROM tasks WHERE id = :task_id AND user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->execute(['task_id' => $task_id, 'user_id' => $user_id]);
$task = $stmt->fetch();

if (!$task) {
    header("Location: dashboard.php");
    exit;
}

// Обробка редагування завдання
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = trim($_POST['task_name']);
    $task_description = trim($_POST['task_description']);
    $status = trim($_POST['status']); 
    $priority = trim($_POST['priority']); 
    $deadline = trim($_POST['deadline']); 

    $update_stmt = $conn->prepare("UPDATE tasks 
        SET task_name = :task_name, task_description = :task_description, status = :status, priority = :priority, deadline = :deadline 
        WHERE id = :task_id AND user_id = :user_id");

    $update_stmt->execute([
        'task_name' => $task_name,
        'task_description' => $task_description,
        'status' => $status, 
        'priority' => $priority, 
        'deadline' => !empty($deadline) ? $deadline : null, 
        'task_id' => $task_id,
        'user_id' => $user_id
    ]);

    header("Location: view_folder.php?id=" . $task['folder_id']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edittasks.css">
    <title>Редагування завдання</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h2>Редагування завдання</h2>
        <form method="POST" action="">

        <label for="task_name">Назва завдання:</label>
        <input type="text" id="task_name" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required><br>

        <label for="task_description">Опис завдання:</label>
        <textarea id="task_description" name="task_description" required><?php echo htmlspecialchars($task['task_description']); ?></textarea><br>

        <label for="status">Статус:</label>
        <select name="status" id="status">
            <option value="Очікує" <?php if ($task['status'] == 'Очікує') echo 'selected'; ?>>Очікує</option>
            <option value="У процесі" <?php if ($task['status'] == 'У процесі') echo 'selected'; ?>>У процесі</option>
            <option value="Завершено" <?php if ($task['status'] == 'Завершено') echo 'selected'; ?>>Завершено</option>
        </select><br>

        <label for="priority">Пріоритет:</label>
        <select name="priority" id="priority">
            <option value="Низький" <?php if ($task['priority'] == 'Низький') echo 'selected'; ?>>Низький</option>
            <option value="Середній" <?php if ($task['priority'] == 'Середній') echo 'selected'; ?>>Середній</option>
            <option value="Високий" <?php if ($task['priority'] == 'Високий') echo 'selected'; ?>>Високий</option>
        </select><br>

        <label for="deadline">Дедлайн:</label>
        <input type="date" id="deadline" name="deadline" value="<?php echo htmlspecialchars($task['deadline']); ?>"><br>
            
            <button type="submit">Зберегти зміни</button>
        </form>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
