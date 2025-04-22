<?php
session_start();

// Подключение к базе данных
$mysqli = new mysqli("127.0.0.1", "root", "123", "test_db");

// Проверка подключения
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

// Обработка формы регистрации
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хеширование пароля
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];

    // Подготовленный запрос для предотвращения SQL-инъекций
    $stmt = $mysqli->prepare("INSERT INTO users (username, password, fullname, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $fullname, $phone);

    if ($stmt->execute()) {
        // Успех, перенаправляем на страницу индекса
        header("Location: login.php");
        exit(); // Прекращаем выполнение скрипта после редиректа
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>
