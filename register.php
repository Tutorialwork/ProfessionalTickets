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
    <title><?php echo REGISTER; ?></title>
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
        if(getSetting("mc_register") == "0"){
            if(isset($_POST["submit"])){
                require("mysql.php");
                $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
                $stmt->bindParam(":user", $_POST["username"], PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->rowCount();
                if($count == 0){
                  $stmt = $mysql->prepare("SELECT * FROM accounts WHERE EMAIL = :mail");
                  $stmt->bindParam(":mail", $_POST["email"], PDO::PARAM_STR);
                  $stmt->execute();
                  $count = $stmt->rowCount();
                  if($count == 0){
                      if($_POST["pw"] == $_POST["pw2"]){
                          $time = time();
                          $stmt = $mysql->prepare("INSERT INTO accounts (USERNAME, EMAIL, PASSWORD, LASTLOGIN, FIRSTLOGIN, ACCOUNTRANK) VALUES (
                              :user, :mail, :pw, :time, :time, 0
                          )");
                          $hash = password_hash($_POST["pw"], PASSWORD_BCRYPT);
                          $stmt->execute(array(":user" => $_POST["username"], ":mail" => $_POST["email"], ":pw" => $hash, ":time" => $time));
                          ?>
                          <div class="success">
                          <?php echo REGISTER_OK; ?>
                          </div>
                          <?php
                      } else {
                          ?>
                          <div class="error">
                          <?php echo REGISTER_PW_ERR; ?>
                          </div>
                          <?php
                      }
                  } else {
                      ?>
                      <div class="error">
                      <?php echo REGISTER_EMAIL_ERR; ?>
                      </div>
                      <?php
                  }
                } else {
                  ?>
                  <div class="error">
                    <?php echo REGISTER_USER_ERR; ?>
                  </div>
                  <?php
                }
              }
               ?>
              <h1><?php echo REGISTER; ?></h1>
              <form action="register.php" method="post">
                <input type="text" name="username" placeholder="<?php echo USERNAME; ?>" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <input type="password" name="pw" placeholder="<?php echo PASSWORD; ?>" required><br>
                <input type="password" name="pw2" placeholder="<?php echo PASSWORD_AGAIN; ?>" required><br>
                <button type="submit" name="submit"><?php echo REGISTER; ?></button>
              </form>
              <br>
              <hr>
              <br>
              <a href="login.php"><button class="btn"><?php echo LOGIN; ?></button></a>
              <?php
        } else {
            ?>
            <h1><?php echo DISABLED_HEADER; ?></h1>
            <p><?php echo DISABLED_MESSAGE; ?></p>
            <?php
        }
        ?>
      </div>
    </div>
  </body>
</html>
