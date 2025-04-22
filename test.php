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

// Получение всех вопросов
$query = "SELECT * FROM questions"; 
$result = $mysqli->query($query);

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row; 
}

// Определение текущей страницы
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$questionsPerPage = 5;
$totalQuestions = count($questions);
$totalPages = ceil($totalQuestions / $questionsPerPage);
$startIndex = ($page - 1) * $questionsPerPage;

// Получаем вопросы для текущей страницы
$currentQuestions = array_slice($questions, $startIndex, $questionsPerPage);

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Сохраняем ответы в сессии
    foreach ($currentQuestions as $row) {
        if (isset($_POST['question_' . $row['id']])) {
            $_SESSION['answers'][$row['id']] = $_POST['question_' . $row['id']];
        }
    }

    // Если это последняя страница, переходим к обработке результатов
    if ($page == $totalPages) {
        header("Location: results.php");
        exit();
    } else {
        // Переходим к следующей странице
        header("Location: ?page=" . ($page + 1));
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Тестирование</title>
    <style>
        body {
            background-image: url('IMG_0011.jpg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin: 0;
            color: white;
        }

        .test-container {
            width: 500px;
            background-color: rgba(0, 0, 0, 0.9);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        h3 {
            color: white;
        }

        input[type="submit"], .pagination a {
            background-color: #4CAF50;
            color: white;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
        }

        .pagination {
            margin-top: 20px;
        }
        
        input[type="radio"]{
            float: left;
        }
        </style>
</head>
<body>

<div class="test-container">
    <?php if (count($currentQuestions) > 0): ?>
        <form action='' method='post'>
            <?php foreach ($currentQuestions as $row): ?>
                <h3><?php echo htmlspecialchars($row['question']); ?></h3>
                <label><input type='radio' name='question_<?php echo $row['id']; ?>' value='1' <?php if (isset($_SESSION['answers'][$row['id']]) && $_SESSION['answers'][$row['id']] == '1') echo 'checked'; ?>><?php echo htmlspecialchars($row['option1']); ?><br></label>
                <label><input type='radio' name='question_<?php echo $row['id']; ?>' value='2' <?php if (isset($_SESSION['answers'][$row['id']]) && $_SESSION['answers'][$row['id']] == '2') echo 'checked'; ?>><?php echo htmlspecialchars($row['option2']); ?><br></label>
                <label><input type='radio' name='question_<?php echo $row['id']; ?>' value='3' <?php if (isset($_SESSION['answers'][$row['id']]) && $_SESSION['answers'][$row['id']] == '3') echo 'checked'; ?>><?php echo htmlspecialchars($row['option3']); ?><br></label>
                <label><input type='radio' name='question_<?php echo $row['id']; ?>' value='4' <?php if (isset($_SESSION['answers'][$row['id']]) && $_SESSION['answers'][$row['id']] == '4') echo 'checked'; ?>><?php echo htmlspecialchars($row['option4']); ?><br></label>
            <?php endforeach; ?>

            <div class='pagination'>
                <?php if ($page > 1): ?>
                    <a href='?page=<?php echo ($page - 1); ?>'>Назад</a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <input type='submit' value='Далее'>
                <?php else: ?>
                    <input type='submit' name='submit' value='Отправить результаты'>
                <?php endif; ?>
            </div>
        </form>
    <?php else: ?>
        <p>Нет вопросов для тестирования.</p>
    <?php endif; ?>

    <?php $mysqli->close(); ?>
</div>

</body>
</html>