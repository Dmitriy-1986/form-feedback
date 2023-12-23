<?php
// Перевірка, чи було відправлено POST-запит від форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Перевірка наявності всіх потрібних даних у POST-запиті
    if (isset($_POST['user_name']) && isset($_POST['user_email']) && isset($_POST['user_message'])) {
        // З'єднання з базою даних (замість 'hostname', 'username', 'password', 'database' введіть відповідні дані)
        $mysqli = new mysqli('localhost', 'root', '', 'feedback-form');

        // Перевірка наявності з'єднання з базою даних
        if ($mysqli->connect_error) {
            die('Помилка з\'єднання з базою даних: ' . $mysqli->connect_error);
        }

        // Підготовка даних для вставки у запит
        $user_name = $mysqli->real_escape_string($_POST['user_name']);
        $user_email = $mysqli->real_escape_string($_POST['user_email']);
        $user_message = $mysqli->real_escape_string($_POST['user_message']);

        // Підготовка SQL-запиту для вставки даних у базу даних
        $sql = "INSERT INTO feedback (user_name, user_email, user_message) VALUES ('$user_name', '$user_email', '$user_message')";

        // Виконання SQL-запиту
        if ($mysqli->query($sql) === TRUE) {
            echo "Дані успішно відправлено!";
        } else {
            echo "Помилка: " . $sql . "<br>" . $mysqli->error;
        }

        // Закриття з'єднання з базою даних
        $mysqli->close();
    } else {
        echo "Будь ласка, заповніть усі поля форми.";
    }

    // Після обробки форми, перенаправлення користувача на іншу сторінку (наприклад, на цю ж саму сторінку)
    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

<div class="container feedback">
    <div class="form-feedback">
        <h2>Форма зворотнього зв'язку</h2><hr>
        <br>
        <form action="index.php" method="post">
            <label for="user-name">Введіть ваше ім'я:</label><br>
            <input type="text" id="user-name" placeholder="Ім'я" name="user_name" required><br><br>
            <label for="user-email">Введіть ваш e-mail:</label><br>
            <input type="email" id="user-email" placeholder="Email" name="user_email" required><br><br>
            <label for="user-message">Введіть повідомлення:</label><br>
            <textarea id="user-message" name="user_message" cols="30" rows="10" placeholder="Повідомлення" required></textarea><br><br>
            <input type="submit" value="Відправити" id="submit-feedback" name="submit_feedback">
        </form>
    </div>
</div>

</body>
</html>
