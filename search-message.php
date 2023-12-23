<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Пошук в базі даних</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>

<?php
$mysqli = new mysqli('localhost', 'root', '', 'feedback-form');

if ($mysqli->connect_error) {
    die('Помилка з\'єднання з базою даних: ' . $mysqli->connect_error);
}

$search_query = isset($_GET['search']) ? $_GET['search'] : '';

if ($search_query !== '') {
    $sql = "SELECT * FROM feedback WHERE user_name LIKE ? OR user_email LIKE ? OR user_message LIKE ?";
    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $search_param = "%$search_query%";
        $stmt->bind_param("sss", $search_param, $search_param, $search_param);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            ?>
            <div class="container">
                <h2>Результати пошуку</h2>
                <form method="GET" action="search-message.php" class="form-search">
                    <input type="text" name="search" placeholder="Введіть запит для пошуку..." class="input-data-search">
                    <button type="submit" class="btn-search">Знайти</button>
                </form>
                <table>
                    <tr><th>#</th><th>Ім'я</th><th>Email</th><th>Повідомлення</th></tr>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . htmlspecialchars($row['user_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['user_email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['user_message']) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
            <?php
        } else {
            ?>
            <div class="container">
                <h2>Дані не знайдено</h2>
                <form method="GET" action="search-message.php" class="form-search">
                    <input type="text" name="search" placeholder="Введіть запит для пошуку..." class="input-data-search">
                    <button type="submit" class="btn-search">Знайти</button>
                </form>
                <p class="res">В результаті пошуку дані не знайдено!</p>
            </div>
            <?php
        }
        $stmt->close();
    } else {
        echo "Помилка підготовки запиту: " . $mysqli->error;
    }
} else {
    ?>
    <div class="container">
        <h2>Пошук в базі даних</h2>
        <form method="GET" action="search-message.php" class="form-search">
            <input type="text" name="search" placeholder="Введіть запит для пошуку..." class="input-data-search">
            <button type="submit" class="btn-search">Знайти</button>
        </form>
    </div>
    <?php
}

$mysqli->close();
?>
</body>
</html>
