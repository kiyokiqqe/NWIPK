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

$task_id = intval($_GET['id']);

// Отримання завдання з бази даних
$query = "SELECT * FROM tasks WHERE id = :task_id AND user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->execute(['task_id' => $task_id, 'user_id' => $user_id]);
$task = $stmt->fetch();

if (!$task) {
    die("Завдання не знайдено або ви не маєте доступу.");
}

$today = date('Y-m-d'); // Поточна дата
$deadline = $task['deadline'];
$isOverdue = (!empty($deadline) && $deadline < $today); // Перевірка простроченого дедлайну
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перегляд завдання</title>
    <link rel="stylesheet" href="css/viewtasks.css">
    <style>
        .overdue { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2><?php echo htmlspecialchars($task['task_name']); ?></h2>
        <p><strong>Опис:</strong> <?php echo nl2br(htmlspecialchars($task['task_description'])); ?></p>
        <p><strong>Статус:</strong> <?php echo htmlspecialchars($task['status']); ?></p>
        <p><strong>Пріоритет:</strong> <?php echo htmlspecialchars($task['priority']); ?></p>
        <p><strong>Дедлайн:</strong> 
            <span class="<?php echo $isOverdue ? 'overdue' : ''; ?>">
                <?php echo !empty($deadline) ? htmlspecialchars($deadline) : 'Не встановлено'; ?>
            </span>
        </p>
        <p><strong>Дата створення:</strong> <?php echo htmlspecialchars($task['created_at']); ?></p>

        <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn-edit">Редагувати</a>
        <a href="delete_task.php?id=<?php echo $task['id']; ?>" class="btn-delete" onclick="return confirm('Ви впевнені?')">Видалити</a>
        <a href="view_folder.php?id=<?php echo $task['folder_id']; ?>" class="btn-back">Назад до списку завдань</a>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
