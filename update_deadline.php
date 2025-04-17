<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Не авторизований.");
}

if (isset($_POST['task_id']) && isset($_POST['deadline'])) {
    $task_id = intval($_POST['task_id']);
    $deadline = $_POST['deadline'];

    // Перевіряємо правильний формат дати (YYYY-MM-DD)
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $deadline) && !empty($deadline)) {
        exit("Невірний формат дати.");
    }

    // Оновлення дедлайну у базі
    $query = "UPDATE tasks SET deadline = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $deadline, $task_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Помилка: " . $stmt->error;
    }
}
?>
