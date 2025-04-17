<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Не авторизований.");
}

if (isset($_POST['task_id']) && isset($_POST['status'])) {
    $task_id = intval($_POST['task_id']);
    $status = $_POST['status'];

    // Перевіряємо допустимі статуси
    $valid_statuses = ['Очікує', 'У процесі', 'Завершено'];
    if (!in_array($status, $valid_statuses)) {
        exit("Невірний статус.");
    }

    // Оновлення статусу у базі
    $query = "UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        exit("Помилка запиту: " . $conn->error);
    }

    $stmt->bind_param("sii", $status, $task_id, $_SESSION['user_id']);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Помилка виконання: " . $stmt->error;
    }
}
?>
