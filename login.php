<?php
session_start();
$error_message = ''; // Переменная для хранения сообщения об ошибке

// Проверяем, есть ли сообщение об ошибке в сессии
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Удаляем сообщение из сессии после его отображения
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <style>
        body {
            background-image: url('IMG_2497.jpg'); /* Замените на путь к вашему изображению */
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }

        .login-container {
            background-color: rgba(33, 82, 35, 0.8);
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

        .error {
            color: red; /* Красный цвет для сообщений об ошибке */
            margin-bottom: 15px;
        }

        .formaction{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Вход</h1>
        
        <?php if ($error_message): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        
        <form class="formaction" action="login_action.php" method="post">
            Логин: <input type="text" name="username" required>
            Пароль: <input type="password" name="password" required>
            <input type="submit" value="Войти">
        </form>
        <p>Еще не зарегистрированы? <a href="register.php" style="color: #4CAF50;">Создайте аккаунт</a></p>
    </div>
</body>
</html>
