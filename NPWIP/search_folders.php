<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Ви не авторизовані.");
}

$user_id = $_SESSION['user_id'];
$search = isset($_POST['search']) ? trim($_POST['search']) : '';

$query = "SELECT * FROM folders WHERE user_id = :user_id AND folder_name LIKE :search";
$stmt = $conn->prepare($query);
$stmt->execute(['user_id' => $user_id, 'search' => "%$search%"]);
$folders = $stmt->fetchAll();

if ($folders) {
    foreach ($folders as $folder) {
        echo '<li class="folder-item">
                <a href="view_folder.php?id=' . $folder['id'] . '">' . htmlspecialchars($folder['folder_name']) . '</a>
                <a href="delete_folder.php?id=' . $folder['id'] . '" class="btn-delete" onclick="return confirm(\'Ви впевнені?\')">Видалити</a>
              </li>';
    }
} else {
    echo '<li>Нічого не знайдено.</li>';
}
?>
