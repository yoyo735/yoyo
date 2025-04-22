<?php
session_start();

// Подключение к базе данных
$mysqli = new mysqli("127.0.0.1", "root", "123", "test_db");

// Проверка подключения
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$score = 0;  // Счетчик правильных ответов
$query = "SELECT * FROM questions";
$result = $mysqli->query($query);

// Подсчет правильных ответов
while ($row = $result->fetch_assoc()) {
    $question_id = $row['id'];
    $correct_option = $row['correct_option'];

    // Проверяем, установлен ли ответ пользователя
    if (isset($_SESSION['answers'][$question_id])) {
        $user_answer = $_SESSION['answers'][$question_id];

        // Увеличиваем счетчик правильных ответов
        if ($user_answer == $correct_option) {
            $score++;
        }
    }
}

// Сохранение результата
$stmt = $mysqli->prepare("INSERT INTO results (user_id, score) VALUES (?, ?)");
$stmt->bind_param("ii", $_SESSION['user_id'], $score);
$stmt->execute();
$stmt->close();

// Очистка ответов пользователя
unset($_SESSION['answers']); // Сброс выбранных вариантов ответов

// Определение результата тестирования
$total_questions = $result->num_rows;
$pass_threshold = 0.6; // 60%
$is_passed = ($score / $total_questions) >= $pass_threshold;
$pass_status = $is_passed ? "Тест успешно пройден" : "Тест не пройден";

// Установка фона в зависимости от результата
$background_image = $is_passed ? 'acceptimg.jpg' : 'IMG_1111.jpg';

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты теста</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('<?php echo $background_image; ?>'); /* Используем переменную для фона */
            background-size: cover;
            color: white; /* Цвет текста */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        .result-container {
            background-color: rgba(0, 0, 0, 0.7); /* Полупрозрачный фон для текста */
            padding: 20px;
            border-radius: 10px;
        }
        h1 {
            font-size: 2em;
        }
        p {
            font-size: 1.5em;
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h1>Ваш результат</h1>
        <p><?php echo "$score из $total_questions"; ?></p>
        <h2><?php echo $pass_status; ?></h2>
        <button onclick="location.href='test.php'">Повторить</button>
    </div>
</body>
</html>
