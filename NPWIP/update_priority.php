<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Не авторизований.");
}

if (isset($_POST['task_id']) && isset($_POST['priority'])) {
    $task_id = intval($_POST['task_id']);
    $priority = $_POST['priority'];

    // Перевіряємо, чи правильний пріоритет
    $valid_priorities = ['Низький', 'Середній', 'Високий'];
    if (!in_array($priority, $valid_priorities)) {
        exit("Невірний пріоритет.");
    }

    // Оновлення пріоритету у базі даних
    $query = "UPDATE tasks SET priority = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $priority, $task_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
