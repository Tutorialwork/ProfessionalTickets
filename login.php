<?php
if(!file_exists("mysql.php")){
  header("Location: setup/index.php");
  exit;
}
session_start();
require("datamanager.php");
require('assets/languages/lang_'.getSetting("lang").'.php');
if(isset($_SESSION["username"])){
  ?>
  <meta http-equiv="refresh" content="0; URL=index.php">
  <?php
  exit;
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo LOGIN; ?></title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="flex">
      <noscript>
        <h1>Please enable JavaScript!</h1>
      </noscript>
      <div class="flex-item login">
        <?php
        if(isset($_POST["submit"])){
          require("mysql.php");
          $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
          $stmt->bindParam(":user", $_POST["username"], PDO::PARAM_STR);
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count == 1){
            $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
            $stmt->bindParam(":user", $_POST["username"], PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch();
            if(password_verify($_POST["pw"], $row["PASSWORD"])){
              $_SESSION["username"] = $row["USERNAME"];
              updateLogin($_SESSION["username"]);
              ?>
              <meta http-equiv="refresh" content="0; URL=index.php">
              <?php
              exit;
            } else {
              ?>
              <div class="error">
                <?php echo LOGIN_ERR; ?>
              </div>
              <?php
            }
          } else {
            ?>
            <div class="error">
              <?php echo LOGIN_ERR; ?>
            </div>
            <?php
          }
        }
         ?>
        <h1><?php echo LOGIN; ?></h1>
        <form action="login.php" method="post">
          <input type="text" name="username" placeholder="<?php echo USERNAME; ?>" required><br>
          <input type="password" name="pw" placeholder="<?php echo PASSWORD; ?>" required><br>
          <button type="submit" name="submit"><?php echo LOGIN; ?></button>
        </form>
        <br>
        <hr>
        <br>
        <button class="btn" onclick="show()"><?php echo LOGIN_BTN; ?></button>
        <div id="create-acc" style="display: none;">
          <?php echo LOGIN_BTN_DESC; ?>
        </div>
        <script type="text/javascript">
        function show() {
          var x = document.getElementById("create-acc");
          if (x.style.display === "none") {
            x.style.display = "block";
          } else {
            x.style.display = "none";
          }
        }
        </script>
      </div>
    </div>
  </body>
</html>
