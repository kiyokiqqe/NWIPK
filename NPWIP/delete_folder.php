<?php
session_start();
include 'includes/db.php'; // Підключення до бази даних

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$folder_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Перевірка, чи ця папка належить користувачу
$check_stmt = $conn->prepare("SELECT id FROM folders WHERE id = :folder_id AND user_id = :user_id");
$check_stmt->execute(['folder_id' => $folder_id, 'user_id' => $user_id]);

if ($check_stmt->rowCount() === 0) {
    header("Location: dashboard.php");
    exit;
}

// Видалення всіх завдань у папці
$delete_tasks_stmt = $conn->prepare("DELETE FROM tasks WHERE folder_id = :folder_id");
$delete_tasks_stmt->execute(['folder_id' => $folder_id]);

// Видалення самої папки
$delete_folder_stmt = $conn->prepare("DELETE FROM folders WHERE id = :folder_id");
$delete_folder_stmt->execute(['folder_id' => $folder_id]);

header("Location: dashboard.php");
exit;
?>
