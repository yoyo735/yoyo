<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тестирование</title>
    <style>
        body {
            background-image: url('IMG_5786.jpg'); /* Замените на путь к вашему изображению */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
            text-align: center;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        h1{
            color: white;
        }

        p{
            color: white;
            text-decoration: none;
        }

        .back{
            background-color: rgba(33, 82, 35, 0.8);
            padding: 40px;
            border-radius: 15px;
            width: 300px;
            text-align: center;
        }

        .reg-log{
            display:flex;
            justify-content: space-evenly;
            align-items: center;
            background-color: rgba(42, 85, 42, 0.7);
            padding: 10px;
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <div class='back'>
        <h1>Добро пожаловать</h1>
        <p>Пожалуйста, выберите действие:</p>
        <div class="reg-log">
        <button onclick="location.href='register.php'">Регистрация</button>
        <button onclick="location.href='login.php'">Логин</button>
        </div>
    </div>
</body>
</html>
