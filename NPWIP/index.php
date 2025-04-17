<?php
session_start();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Task Manager – ефективне управління завданнями з доступом звідусіль.">
    <title>Task Manager – Керуйте своїми завданнями легко</title>
    
    
    <link rel="stylesheet" type="" href="css/indexforstyles.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    
    <script defer src="includes/script.js"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="hero">
        <div class="content visible">
            <h1>Організуйте свої завдання ефективно</h1>
            <p>Task Manager – це простий і зручний інструмент для управління вашими справами.</p>
            <a href="register.php" class="btn">Почати зараз</a>
        </div>
    </section>

    <section class="features">
        <div class="feature">
            <i class="fa-solid fa-tasks"></i>
            <h3>Зручне управління</h3>
            <p>Групуйте завдання за категоріями, встановлюйте пріоритети та дедлайни.</p>
        </div>
        <div class="feature">
            <i class="fa-solid fa-bullseye"></i>
            <h3>Зручне керування статусами</h3>
            <p>Швидко змінюйте статуси завдань та контролюйте їхнє виконання.</p>
        </div>
        <div class="feature">
            <i class="fa-solid fa-cloud"></i>
            <h3>Доступ звідусіль</h3>
            <p>Ваші завдання доступні з будь-якого пристрою.</p>
        </div>
    </section>

    <section class="cta visible">
        <h2>Розпочніть роботу вже сьогодні!</h2>
        <a href="register.php" class="btn">Приєднатися зараз</a>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
