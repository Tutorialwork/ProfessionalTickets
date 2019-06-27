<?php
if(file_exists("../mysql.php")){
  header("Location: ../index.php");
  exit;
}
session_start();
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Setup</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="flex">
      <noscript>
        <h1>Please enable JavaScript!</h1>
      </noscript>
      <div class="flex-item login">
        <?php
        require("../datamanager.php");
        if(isset($_POST["submit"])){
          $host = $_POST["host"];
          $name = $_POST["database"];
          $user = $_POST["user"];
          $passwort = $_POST["password"];
          try{
              $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
              $_SESSION["host"] = $_POST["host"];
              $_SESSION["database"] = $_POST["database"];
              $_SESSION["user"] = $_POST["user"];
              $_SESSION["password"] = $_POST["password"];
              ?>
              <meta http-equiv="refresh" content="0; URL=step2.php">
              <?php
              exit;
          } catch (PDOException $e){
              //showModal("ERROR", "MySQL Errror", "Unable to connect to the MySQL database.");
              ?>
              <div class="error">
                Unable to connect to the MySQL database.
              </div>
              <?php
          }
        }
         ?>
        <h1>Setup</h1>
        <p>Please setting up your MySQL database.</p>
        <form action="index.php" method="post">
          <input type="text" name="host" placeholder="Host" value="localhost" required>
          <input type="text" name="database" placeholder="Database" required>
          <input type="text" name="user" placeholder="User" required>
          <input type="password" name="password" placeholder="Password">
          <button type="submit" name="submit">Continue</button>
        </form>
      </div>
    </div>
  </body>
</html>
