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
      <tr>
        <th>Название</th>
        <th>Автор</th>
        <th>Год выпуска</th>
        <th>ISBN</th>
        <th>Жанр</th>
      </tr>
      <?php
// подключение к db
      try {
      $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8;",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      }
      catch (PDOException $e) {
        echo "Невозможно установить соединение с базой данных";
        exit();
      }
// поиск
      if(!empty($_GET['isbn']) or !empty($_GET['name']) or !empty($_GET['author'])){
        $isbn = $_GET['isbn'];
        $name = $_GET['name'];
        $author = $_GET['author'];

        $sql2 = "SELECT * FROM `books` WHERE `isbn` LIKE  ? AND `name` LIKE ? AND `author` LIKE ? ";
        $statements = $pdo->prepare($sql2);
        $params = ["%".$isbn."%","%". $name."%","%". $author."%"];
        $statements->execute($params);

        while ($rows = $statements->fetch(PDO::FETCH_ASSOC)) {
          $resultsy[] = $rows;
        }
// если не найдено
        if(empty($resultsy)){
          echo 'Ничего не было найдено!';
        } else {
          foreach ($resultsy as $keysy => $valuessy) {
          ?>
            <tr>
              <td><?=$valuessy['name'];?></td>
              <td><?=$valuessy['author'];?></td>
              <td><?=$valuessy['year'];?></td>
              <td><?=$valuessy['isbn'];?></td>
              <td><?=$valuessy['genre'];?></td>
            </tr> 
          <?php
          }
        }
      }else{
//все книги
        $sql = "SELECT * FROM `books`";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $results[] = $row;
        }
    
        foreach ($results as $key => $values) {
        ?>
          <tr>
            <td><?=$values['name'];?></td>
            <td><?=$values['author'];?></td>
            <td><?=$values['year'];?></td>
            <td><?=$values['isbn'];?></td>
            <td><?=$values['genre'];?></td>
          </tr>
        <?php
        }
      }
      ?>
    </table>
  </body>
</html>
