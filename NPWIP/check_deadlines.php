<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Не авторизований.");
}

$user_id = $_SESSION['user_id'];
$today = date('Y-m-d');

$query = "SELECT * FROM tasks WHERE user_id = ? AND deadline <= ? AND status != 'Завершено'";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();

$tasks_due_today = [];
while ($task = $result->fetch_assoc()) {
    $tasks_due_today[] = $task['task_name'] . " (дедлайн: " . $task['deadline'] . ")";
}

if (!empty($tasks_due_today)) {
    echo "Нагадування: Прострочені або дедлайни на сьогодні → " . implode(", ", $tasks_due_today);
} else {
    echo "На сьогодні дедлайнів немає.";
}
?>
