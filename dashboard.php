<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
include 'includes/db.php';

$query = "SELECT id, folder_name FROM folders WHERE user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$folders = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мій кабінет</title>
    <link rel="stylesheet" href="css/fordashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <div class="container dashboard-container">
        <h2>Вітаємо у вашому кабінеті</h2>
        <p>Тут ви можете переглядати та керувати своїми папками та завданнями.</p>
        <h3>Ваші папки</h3>
        <input type="text" id="search" placeholder="Шукати папку...">
        <ul id="folder-list">
            <?php foreach ($folders as $folder): ?>
                <li class="folder-item">
                    <a href="view_folder.php?id=<?php echo $folder['id']; ?>">
                        <?php echo htmlspecialchars($folder['folder_name']); ?>
                    </a>
                    <a href="delete_folder.php?id=<?php echo $folder['id']; ?>" class="btn-delete" onclick="return confirm('Ви впевнені?')">Видалити</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <h3>Додати нову папку</h3>
        <form action="add_folder.php" method="POST">
            <input type="text" name="folder_name" placeholder="Назва нової папки" required>
            <button type="submit">Створити папку</button>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                let query = $(this).val().trim();
                $.ajax({
                    url: "search_folders.php",
                    method: "POST",
                    data: { search: query },
                    success: function(response) {
                        $("#folder-list").html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>
