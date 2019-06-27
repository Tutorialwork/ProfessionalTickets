<?php
if(file_exists("../mysql.php")){
  header("Location: ../index.php");
  exit;
}
require("../datamanager.php");
session_start();
if(isset($_SESSION["host"]) && isset($_SESSION["database"]) &&
isset($_SESSION["user"]) && isset($_SESSION["password"])){
  if(isset($_POST["submit"])){
    $mysqlfile = fopen("../mysql.php", "w");
    if(!$mysqlfile){
      ?>
      <head>
        <meta charset="utf-8">
        <title>Setup</title>
        <link rel="stylesheet" href="../assets/css/main.css">
        <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
      </head>
      <body>
        <div class="flex">
          <div class="flex-item login">
            <h1>Error</h1>
            <p>Installation failed. Reason: Can't write mysql.php <br>
              Please make sure that the ProfessionalTickets folder is writable.</p>
            <br>
            <a href="step3.php" class="btn">Try again</a>
          </div>
        </div>
      </body>
      <?php
      exit;
    }
    echo fwrite($mysqlfile, '
    <?php
    $host = "'.$_SESSION["host"].'";
    $name = "'.$_SESSION["database"].'";
    $user = "'.$_SESSION["user"].'";
    $passwort = "'.$_SESSION["password"].'";
    try{
        $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
    } catch (PDOException $e){

    }
    ?>
    ');
    fclose($mysqlfile);
    session_destroy();
    setSetting("lang", $_POST["lang"]);
    setSetting("captcha", $_POST["captcha"]);
    setSetting("captcha_public", $_POST["captcha-public"]);
    setSetting("captcha_private", $_POST["captcha-secret"]);
    ?>
    <meta http-equiv="refresh" content="0; URL=../index.php">
    <?php
    exit;
  }
} else {
  header("Location: index.php");
  exit;
}
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
      <div class="flex-item login">
        <h1>Setup</h1>
        <p>Now you can change the default settings.</p>
        <form action="step3.php" method="post">
          <select name="lang">
            <option value="en">English</option>
            <option value="de">German (Deutsch)</option>
          </select>
          <h3>Captcha</h3>
          <select name="captcha">
            <option value="0">Disabled</option>
            <option value="1">Enabled</option>
          </select>
          <p>Create this keys for free on: <a href="https://www.google.com/recaptcha/admin">Google ReCaptcha</a> (Only needed if captcha enabled!)</p>
          <input type="text" name="captcha-public" placeholder="Your website key"><br>
          <input type="text" name="captcha-secret" placeholder="Your secret key"><br>
          <button type="submit" name="submit">Finish</button>
        </form>
      </div>
    </div>
  </body>
</html>
