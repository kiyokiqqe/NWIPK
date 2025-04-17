<?php

session_start();

include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$folder_id = intval($_GET['id']);

// Отримуємо папку
$query = "SELECT * FROM folders WHERE id = :folder_id AND user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->execute(['folder_id' => $folder_id, 'user_id' => $user_id]);
$folder = $stmt->fetch();

if (!$folder) {
    die("Папка не знайдена або ви не маєте доступу.");
}

// Отримуємо завдання
$tasks_query = "SELECT * FROM tasks WHERE folder_id = :folder_id AND user_id = :user_id";
$tasks_stmt = $conn->prepare($tasks_query);
$tasks_stmt->execute(['folder_id' => $folder_id, 'user_id' => $user_id]);
$tasks = $tasks_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Завдання в папці: <?php echo htmlspecialchars($folder['folder_name']); ?></title>
    <link rel="stylesheet" href="/css/viewfolder.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container">
        <h2>Завдання в папці: <?php echo htmlspecialchars($folder['folder_name']); ?></h2>
        <a href="add_task.php?id=<?php echo $folder_id; ?>" class="btn-create-task">Створити нове завдання</a>
        <h3>Список завдань</h3>
        <input type="text" id="search-tasks" placeholder="Шукати завдання..." onkeyup="searchTasks()">
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li class="task-item">
                    <?php echo htmlspecialchars($task['task_name']); ?>
                    <a href="view_task.php?id=<?php echo intval($task['id']); ?>">Переглянути</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script>
        function searchTasks() {
            let query = document.getElementById('search-tasks').value.toLowerCase().trim();
            document.querySelectorAll('.task-item').forEach(task => {
                let taskName = task.textContent.toLowerCase().trim();
                task.style.display = taskName.includes(query) ? '' : 'none';
            });
        }
    </script>
    <?php include 'includes/footer.php'; ?>
</body>
</html>
