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
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo SIDEBAR_ACCSETTINGS ?></title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  </head>
  <body>
    <div class="flex">
      <div class="flex-item">
        <?php
        if(isset($_POST["submit"])){
          require("mysql.php");
          $hash = null;
          if(!empty($_POST["pw"]) && !empty($_POST["pw2"])){
            if($_POST["pw"] == $_POST["pw2"]){
              $hash = password_hash($_POST["pw"], PASSWORD_BCRYPT);
            } else {
              ?>
              <div class="error">
                <?php echo PW_ERR; ?>
              </div>
              <?php
            }
          }
          if($hash == null){
            $stmt = $mysql->prepare("UPDATE accounts SET EMAIL = :email WHERE USERNAME = :user");
            $stmt->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
            $stmt->bindParam(":user", $_SESSION["username"], PDO::PARAM_STR);
            $stmt->execute();
          } else {
            $stmt = $mysql->prepare("UPDATE accounts SET EMAIL = :email, PASSWORD = :pw WHERE USERNAME = :user");
            $stmt->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
            $stmt->bindParam(":user", $_SESSION["username"], PDO::PARAM_STR);
            $stmt->bindParam(":pw", $hash, PDO::PARAM_STR);
            $stmt->execute();
          }
        }
         ?>
        <h1><?php echo SIDEBAR_ACCSETTINGS ?></h1>
        <form action="settings.php" method="post">
          <input type="email" name="email" value="<?php echo getAccountEmail($_SESSION["username"]); ?>" placeholder="Email" required>
          <input type="password" name="pw" placeholder="<?php echo PW_FORM; ?>">
          <input type="password" name="pw2" placeholder="<?php echo PW_FORM_2; ?>">
          <button type="submit" name="submit"><?php echo SAVE; ?></button>
        </form>
        <h3><?php echo htmlspecialchars($_SESSION["username"]); ?></h3>
        <p><?php echo RANK; ?>: <strong><?php
        if(getAccountRank($_SESSION["username"]) == 3 || getAccountRank($_SESSION["username"]) == 2){
          echo "Admin";
        } else if(getAccountRank($_SESSION["username"]) == 1){
          echo "Team";
        } else if(getAccountRank($_SESSION["username"]) == 0){
          echo MEMBER;
        }
         ?></strong> </p>
        <p><?php echo LASTLOGIN; ?>: <strong><?php echo displayTimestamp(getLastLoginDate($_SESSION["username"])); ?></strong> </p>
        <p><?php echo FIRSTLOGIN; ?>: <strong><?php echo displayTimestamp(getFirstLoginDate($_SESSION["username"])); ?></strong> </p>
      </div>
      <div class="flex-item sidebar">
        <?php require('assets/inc/sidebar.inc.php'); ?>
      </div>
    </div>
  </body>
</html>
