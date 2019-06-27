<?php
if(!file_exists("mysql.php")){
  header("Location: setup/index.php");
  exit;
}
session_start();
require("datamanager.php");
require('assets/languages/lang_'.getSetting("lang").'.php');
if(!isset($_SESSION["username"])){
  ?>
  <meta http-equiv="refresh" content="0; URL=login.php">
  <?php
  exit;
} else if(getAccountRank($_SESSION["username"]) < 3){
  ?>
  <meta http-equiv="refresh" content="0; URL=mytickets.php">
  <?php
  exit;
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo FAQ_CREATE_HEADING; ?></title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
    <div class="flex">
      <div class="flex-item">
        <?php
        require("mysql.php");
        if(isset($_POST["submit"])){
          $stmt = $mysql->prepare("INSERT INTO faq (QUESTION, ANSWER)
          VALUES (:q, :a)");
          $stmt->bindParam(":q", $_POST["question"], PDO::PARAM_STR);
          $stmt->bindParam(":a", $_POST["answer"], PDO::PARAM_STR);
          $stmt->execute();
          ?>
          <meta http-equiv="refresh" content="0; URL=admin.php">
          <?php
        }
         ?>
        <h1><?php echo FAQ_CREATE_HEADING; ?></h1>
        <form action="addfaq.php" method="post">
          <input type="text" name="question" placeholder="<?php echo QUESTION; ?>" minlength="3" required><br>
          <textarea name="answer" rows="8" cols="80" placeholder="<?php echo ANSWER; ?>" minlength="16" required></textarea><br>
          <button type="submit" name="submit"><?php echo ADD; ?></button><br>
        </form>
      </div>
      <div class="flex-item sidebar">
        <?php require('assets/inc/sidebar.inc.php'); ?>
      </div>
    </div>
  </body>
</html>
