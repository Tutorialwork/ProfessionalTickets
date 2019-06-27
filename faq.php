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
    <title>FAQ</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  </head>
  <body>
    <div class="flex">
      <noscript>
        <h1>Please enable JavaScript!</h1>
      </noscript>
      <div class="flex-item">
        <h1>FAQ</h1>
        <div class="faq">
          <ul>
            <?php
            require("mysql.php");
            $stmt = $mysql->prepare("SELECT * FROM faq");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
              ?>
              <li onclick="show(<?php echo $row["ID"]; ?>)"><?php echo $row["QUESTION"]; ?> <i id="icon-<?php echo $row["ID"]; ?>" class="fas fa-plus"></i></li>
              <div id="answer-<?php echo $row["ID"]; ?>" style="display: none;">
                <p><?php echo $row["ANSWER"]; ?></p>
              </div>
              <?php
            }
             ?>
          </ul>
        </div>
        <script type="text/javascript">
        function show(answer) {
          var x = document.getElementById("answer-"+answer);
          var icon = document.getElementById("icon-"+answer);
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
          if (icon.classList.contains("fa-plus")) {
            icon.classList.remove("fa-plus");
            icon.classList.add("fa-minus");
          } else {
            icon.classList.remove("fa-minus");
            icon.classList.add("fa-plus");
          }
        }
        </script>
      </div>
      <div class="flex-item sidebar">
        <?php require('assets/inc/sidebar.inc.php'); ?>
      </div>
    </div>
  </body>
</html>
