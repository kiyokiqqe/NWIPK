<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Ви не авторизовані.");
}

$user_id = $_SESSION['user_id'];
$folder_id = intval($_GET['folder_id'] ?? 0);
$search = isset($_POST['search']) ? trim($_POST['search']) : '';

$query = "SELECT * FROM tasks WHERE user_id = ? AND folder_id = ? AND task_name LIKE ?";
$stmt = $conn->prepare($query);
$search_param = "%" . $search . "%";
$stmt->bind_param("iis", $user_id, $folder_id, $search_param);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($task = $result->fetch_assoc()) {
        echo '<li class="task-item">' . htmlspecialchars($task['task_name']) . '</li>';
    }
} else {
    echo '<li>Нічого не знайдено.</li>';
}
?>
