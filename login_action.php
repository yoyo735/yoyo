<?php
session_start();

// Подключение к базе данных
$mysqli = new mysqli("127.0.0.1", "root", "123", "test_db");

// Проверка подключения
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

// Обработка формы логина
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Подготовленный запрос для предотвращения SQL-инъекций
    $stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    
    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id; // Сохранение ID пользователя в сессии
            header("Location: test.php");
            exit();
        } else {
            // Неверный пароль
            $_SESSION['error_message'] = "Неверный пароль.";
        }
    } else {
        // Пользователь не найден
        $_SESSION['error_message'] = "Пользователь не найден.";
    }

    $stmt->close();
}

$mysqli->close();
header("Location: login.php");
exit();
?>
