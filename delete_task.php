<?php

session_start();

include 'includes/db.php'; // Підключення до бази даних

// Перевірка авторизації
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Отримання ID завдання
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: tasks.php");
    exit;
}

$task_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Видалення завдання
$stmt = $conn->prepare("DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id");
$stmt->execute(['task_id' => $task_id, 'user_id' => $user_id]);

if ($stmt->rowCount() > 0) {
    header("Location: tasks.php?success=deleted");
    exit;
} else {
    header("Location: tasks.php?error=delete");
    exit;
}

?>
