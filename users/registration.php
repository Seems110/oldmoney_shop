<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

// Подключение к базе данных
require_once "database.php";
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Обработка данных формы
if (isset($_POST["submit"])) {
    $fullName = htmlspecialchars($_POST["fullname"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $repeatPassword = htmlspecialchars($_POST["repeat_password"]);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Проверка данных
    if (empty($fullName) || empty($email) || empty($password) || empty($repeatPassword)) {
        echo "<div class='error-message'>All fields are required</div>";
    } elseif ($password !== $repeatPassword) {
        echo "<div class='error-message'>Passwords do not match</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='error-message'>Invalid email format</div>";
    } else {
        // Проверка существующего email
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                echo "<div class='error-message'>Email already exists</div>";
            } else {
                // Вставка данных
                $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                    if (mysqli_stmt_execute($stmt)) {
                        echo "<div class='alert-success'>Registration successful! Redirecting to login page...</div>";
                        header("refresh:3;url=profile.html");
                        exit();
                    } else {
                        echo "<div class='error-message'>Error: Unable to register user</div>";
                    }
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "<div class='error-message'>Something went wrong. Please try again later.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            padding-top: 70px;
            background-color: #1e272e;
            color: #ecf0f1;
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
            background-color: #2f3640;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            color: #ecf0f1;
        }

        .form-control {
            background-color: #1e272e;
            color: #ecf0f1;
            border: 1px solid #7f8c8d;
        }

        .form-control:focus {
            background-color: #2f3640;
            border-color: #3498db;
            outline: none;
        }

        .btn-primary {
            background-color: #3498db;
            color: #ecf0f1;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        a {
            color: #3498db;
        }

        a:hover {
            color: #2980b9;
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
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.html">OLD MONEY STORE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="about.html">О нас</a></li>
                <li class="nav-item"><a class="nav-link" href="contacts.html">Контакты</a></li>
                <li class="nav-item"><a class="nav-link" href="delivery.html">Доставка</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.html">Мой профиль</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Войти</a></li>
                <li class="nav-item"><a class="nav-link active" href="registration.php">Регистрация</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Регистрация</h1>
    <form action="" method="post">
        <div class="form-group mb-3">
            <label for="fullname" class="form-label">Full Name:</label>
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name:" required>
        </div>
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email:" required>
        </div>
        <div class="form-group mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password:" required>
        </div>
        <div class="form-group mb-3">
            <label for="repeat_password" class="form-label">Repeat Password:</label>
            <input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="Repeat Password:" required>
        </div>
        <div class="form-group text-center">
            <input type="submit" class="btn btn-primary w-100" value="Register" name="submit">
        </div>
    </form>
    <div><p class="text-center mt-3">Already Registered? <a href="login.php">Login Here</a></p></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
