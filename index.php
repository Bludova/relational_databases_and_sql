<?php
 include './config.php';
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Реляционные базы данных и SQL</title>
<style>
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }
 
    table td, table th {
        border: 1px solid #ccc;
        padding: 5px;
    }
 
    table th {
        background: #eee;
    }
</style>
</head>
 <body>
<h1>Бибилиотека</h1>
<form action="" method="get" name="form">
    <input name="isbn" type="text" placeholder="ISBN" value="">
    <input name="name" type="text" placeholder="Название книги" value="">
    <input name="author" type="text" placeholder="Автор книги" value="">
    <input type="submit" value="Поиск">
</form>
 
<table>
    <tbody>
    <tr>
        <th>Название</th>
        <th>Автор</th>
        <th>Год выпуска</th>
        <th>ISBN</th>
        <th>Жанр</th>
    </tr>
    <?php
    $connection = new mysqli($host, $user, $password, $db);
    $connection->set_charset('utf8');
    if ( $connection == false)
    {
        echo 'Не удалось подключиться к базе данных !<br>';
        echo mysqli_connection_error();
        die();
    }
 
    If(isset($_GET['isbn']) or isset($_GET['name']) or isset($_GET['author'])) {
        $requestISBN = "SELECT * FROM `books` WHERE `isbn` LIKE '%" . $_GET['isbn'] . "%'
       AND `name` LIKE '%" . $_GET['name'] . "%' AND `author` LIKE '%" . $_GET['author'] . "%' ";
        $query = mysqli_query($connection, $requestISBN);
        while ($row = mysqli_fetch_assoc($query))
        {
            echo '<tr>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['author'] . '</td>';
            echo '<td>' . $row['year'] . '</td>';
            echo '<td>' . $row['isbn'] . '</td>';
            echo '<td>' . $row['genre'] . '</td>';
            echo '</tr>';
        }
    } else {
 
 
        $requestDefault = "SELECT * FROM `books`";
 
        $query = mysqli_query($connection, $requestDefault);
 
        while ($row = mysqli_fetch_assoc($query))
        {
            echo '<tr>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['author'] . '</td>';
            echo '<td>' . $row['year'] . '</td>';
            echo '<td>' . $row['isbn'] . '</td>';
            echo '<td>' . $row['genre'] . '</td>';
            echo '</tr>';
        }
    }
    ?>
 
</tbody>
</table>
</body>
</html>
</html>