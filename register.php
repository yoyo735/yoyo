<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <style>
        body {
            background-image: url('IMG_4770.png'); /* Замените на путь к вашему изображению */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }

        .register-container {
            background-color: rgba(33, 82, 35, 0.88);
            padding: 40px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        input {
            display: block;
            margin: 10px 0;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        .formaction{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Регистрация</h1>
        <form class="formaction" action="register_action.php" method="post">
            Логин: <input type="text" name="username" required>
            Пароль: <input type="password" name="password" required>
            ФИО: <input type="text" name="fullname" required>
            Номер телефона: <input type="text" name="phone" required>
            <input type="submit" value="Зарегистрироваться">
        </form>
        <p>Уже зарегистрированы? <a href="login.php" style="color: #4CAF50;">Войдите</a></p>
    </div>
</body>
</html>
