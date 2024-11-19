<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1e272e; /* Серый фон */
            color: #ecf0f1; /* Светлый текст */
        }

        nav.navbar {
            background-color: #2f3640;
        }

        .navbar-brand, .nav-link {
            color: #ecf0f1 !important;
        }

        .nav-link.active {
            color: #3498db !important;
        }

        footer {
            background-color: #2f3640;
            color: #ecf0f1;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">OLD MONEY STORE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacts.html">Контакты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="delivery.html">Доставка</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.html">Мой профиль</a>
                </li>
                <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Войти</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Выйти</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Добро пожаловать в наш онлайн-магазин OLD MONEY STORE</h1>
    <p class="text-center">Наслаждайтесь уникальным шопингом!</p>
</div>

<footer>
    OLD MONEY © Я больше не буду покупать харамные акции
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
