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

    <div class="container">
        <h2>Всі повідомлення користувачів</h2>
        <?php
        // Підключення до бази даних (замість 'hostname', 'username', 'password', 'database' введіть відповідні дані)
        $mysqli = new mysqli('localhost', 'root', '', 'feedback-form');

        // Перевірка наявності з'єднання з базою даних
        if ($mysqli->connect_error) {
            die('Помилка з\'єднання з базою даних: ' . $mysqli->connect_error);
        }

        // Виконання запиту до бази даних
        $sql = "SELECT * FROM feedback"; // Замість 'feedback' вкажіть вашу назву таблиці
        $result = $mysqli->query($sql);

        // Перевірка наявності результатів запиту
        if ($result->num_rows > 0) {
            // Виведення даних у таблицю
            echo '<table>';
            echo '<tr><th>#</th><th>Ім\'я</th><th>Email</th><th>Повідомлення</th></tr>';

            // Виведення рядків з результатами запиту
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo '<td>' . $row['user_email'] . '</td>';
                echo '<td>' . $row['user_message'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '</div>';
        } else {
            echo "Немає даних для відображення.";
        }

        // Закриття з'єднання з базою даних
        $mysqli->close();
        ?>
    </div>

</body>
</html>
