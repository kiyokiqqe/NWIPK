<?php
$host = 'localhost';
$dbname = 'task_manager';
$username = 'root';
$password = '';

try {
    // Створення підключення через PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES => false 
    ]);
} catch (PDOException $e) {
   
    die("Помилка підключення до бази даних: " . $e->getMessage());
}
?>
