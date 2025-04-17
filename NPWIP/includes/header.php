<?php session_start(); ?>
<header> 
    <div class="container">
        <h1><a href="index.php">Task Manager</a></h1>
        <nav>
            <ul>
                <li><a href="index.php" class="btn">Головна</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard.php" class="btn">Мій кабінет</a></li>
                    <li><a href="logout.php" class="btn">Вийти</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="btn">Ввійти</a></li>
                    <li><a href="register.php" class="btn">Зареєструватись</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<style>
/* Стилі для хедера */
header {
    background-color: rgba(30, 30, 30, 0.9);
    backdrop-filter: blur(5px);
    color: #fff;
    padding: 15px 0;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
}

header .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
}

header nav ul {
    list-style: none;
    display: flex;
    gap: 20px;
    margin: 0;
    padding: 0;
}

header nav ul li {
    list-style: none;
}

/* Вирівнюємо всі кнопки в меню */
header nav ul li a {
    display: inline-block;
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 5px;
    transition: 0.3s;
}

/* Стиль для звичайних посилань */
header nav ul li a:not(.btn) {
    color: var(--text-light);
    font-size: 16px;
}

/* Стиль для кнопок */
header nav ul li a.btn {
    background: linear-gradient(45deg, var(--primary), var(--secondary));
    color: white;
    font-weight: bold;
    padding: 7px 12px; 
    font-size: 15px; 
    border-radius: 6px; 
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}


/* Анімація кнопок при наведенні */
header nav ul li a.btn:hover {
    transform: scale(1.05);
    box-shadow: var(--btn-hover-shadow);
}

/* Стилі заголовка "Task Manager" */
header h1 a {
    font-size: 28px;
    font-weight: bold;
    text-transform: uppercase;
    background: linear-gradient(45deg, #007BFF, #00D4FF);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 0 5px rgba(0, 212, 255, 0.5);
    transition: text-shadow 0.3s ease-in-out;
    position: relative;
}

/* Ефект світіння при наведенні */
header h1 a:hover {
    text-shadow: 0 0 10px rgba(0, 212, 255, 0.8);
}

/* Анімація мерехтіння */
@keyframes glowText {
    0% { text-shadow: 0 0 5px rgba(0, 212, 255, 0.3); }
    100% { text-shadow: 0 0 10px rgba(0, 212, 255, 0.5); }
}

header h1 a {
    animation: glowText 3s alternate infinite ease-in-out;
}
</style>
