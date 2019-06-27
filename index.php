<?php
if(!file_exists("mysql.php")){
  header("Location: setup/index.php");
  exit;
}
session_start();
require("datamanager.php");
require('assets/languages/lang_'.getSetting("lang").'.php');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo INDEX_HEADING; ?></title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  </head>
  <body>
    <div class="flex">
      <div class="flex-item">
        <h1><?php echo INDEX_HEADING; ?></h1>
        <p><?php echo INDEX; ?></p>
        <br>
        <a href="createticket.php" class="btn"><?php echo INDEX_BTN; ?></a>
      </div>
      <div class="flex-item sidebar">
        <?php require('assets/inc/sidebar.inc.php'); ?>
      </div>
    </div>
    <div class="flex">
      <div class="flex-item">
        <?php require('assets/inc/faq.inc.php'); ?>
      </div>
    </div>
  </body>
</html>
