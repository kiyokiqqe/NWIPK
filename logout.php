<?php
session_start();
session_unset();  // Видаляє всі змінні сесії
session_destroy(); // Знищує сесію

// Видаляємо cookie сесії (якщо використовується)
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Перенаправлення на головну сторінку
header("Location: index.php");
exit;
?>
