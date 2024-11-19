<?php
session_start();
if (isset($_SESSION['user'])) {
    echo "Session user: " . $_SESSION['user'];
    header("Location: registation.php");
    exit();
}

// Подключение к базе данных
require_once "database.php";
if (!$conn) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Обработка данных формы
if (isset($_POST["login"])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    // Проверка данных
    if (empty($email) || empty($password)) {
        echo "<div class='error-message'>Все поля обязательны для заполнения</div>";
    } else {
        // Проверяем существование email
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($user = mysqli_fetch_assoc($result)) {
                // Проверяем пароль
                if (password_verify($password, $user['password'])) {
                    $_SESSION["user"] = $user["id"]; // Сохраняем ID пользователя в сессии
                    echo "<div class='alert-success'>Вход выполнен успешно! Перенаправление...</div>";
                    header("Location: ../index.php");
                    exit();
                } else {
                    echo "<div class='error-message'>Неверный пароль</div>";
                }
            } else {
                echo "<div class='error-message'>Пользователь с таким email не найден</div>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='error-message'>Произошла ошибка. Попробуйте позже</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 70px;
            background-color: #1e272e; /* Серый фон */
            color: #ecf0f1; /* Светлый текст */
            font-family: 'Arial', sans-serif;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }

        .container {
            max-width: 400px;
            background-color: #2f3640; /* Темно-серый фон контейнера */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            color: #ecf0f1;
        }

        .form-control {
            background-color: #1e272e; /* Серый цвет полей */
            color: #ecf0f1;
            border: 1px solid #7f8c8d;
        }

        .form-control:focus {
            background-color: #2f3640;
            border-color: #3498db; /* Синий акцент */
            outline: none;
        }

        .btn-primary {
            background-color: #3498db; /* Синий цвет кнопки */
            color: #ecf0f1;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9; /* Темно-синий при наведении */
        }

        a {
            color: #3498db; /* Ссылки в синем */
        }

        a:hover {
            color: #2980b9; /* Темнее при наведении */
        }

        nav.navbar {
            background-color: #2f3640; /* Серый navbar */
        }

        .navbar-brand, .nav-link {
            color: #ecf0f1 !important;
        }

        .nav-link.active {
            color: #3498db !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="project/users/index.php">OLD MONEY STORE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../index.html">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="../users/about.html">О нас</a></li>
                <li class="nav-item"><a class="nav-link" href="../users/contacts.html">Контакты</a></li>
                <li class="nav-item"><a class="nav-link" href="../users/delivery.html">Доставка</a></li>
                <li class="nav-item"><a class="nav-link" href="../users/profile.html">Мой профиль</a></li>
                <li class="nav-item"><a class="nav-link active" href="../users/login.php">Войти</a></li>
                <li class="nav-item"><a class="nav-link" href="../users/registration.php">Регистрация</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Вход</h1>
    <form action="" method="post">
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Введите email" required>
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label">Пароль:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль" required>
        </div>
        <div class="form-group text-center">
            <input type="submit" class="btn btn-primary w-100" value="Войти" name="login">
        </div>
    </form>
    <div><p class="text-center mt-3">Нет аккаунта? <a href="registration.php">Зарегистрироваться</a></p></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

