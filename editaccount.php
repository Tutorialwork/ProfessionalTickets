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
} else if(getAccountRank($_SESSION["username"]) < 2){
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
    <title>Edit Account</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  </head>
  <body>
    <div class="flex">
      <div class="flex-item">
        <?php
        if(isset($_GET["user"])){
          if(getAccountRank($_GET["user"]) != 3){
            if($_GET["user"] != $_SESSION["username"]){
              if(isset($_POST["submit"])){
                require("mysql.php");
                $stmt = $mysql->prepare("UPDATE accounts SET ACCOUNTRANK = :id WHERE USERNAME = :user");
                $stmt->bindParam(":user", $_GET["user"], PDO::PARAM_STR);
                $stmt->bindParam(":id", $_POST["rank"], PDO::PARAM_STR);
                $stmt->execute();
                ?>
                <div class="success">
                  <?php echo SAVED_CHANGE; ?>
                </div>
                <?php
              }
              ?>
                <h1><?php echo $_GET["user"]; ?></h1>
                <p><?php echo LASTLOGIN; ?>: <strong><?php echo displayTimestamp(getLastLoginDate($_GET["user"])); ?></strong> </p>
                <p><?php echo FIRSTLOGIN; ?>: <strong><?php echo displayTimestamp(getFirstLoginDate($_GET["user"])); ?></strong> </p>
                <br>
                <hr>
                <br>
                <form action="editaccount.php?user=<?php echo $_GET["user"]; ?>" method="post">
                  <select name="rank">
                    <?php
                    if(getAccountRank($_GET["user"]) == 2){
                      ?>
                      <option value="2">Admin</option>
                      <option value="1">Team</option>
                      <option value="0"><?php echo MEMBER; ?></option>
                      <?php
                    } else if(getAccountRank($_GET["user"]) == 1){
                      ?>
                      <option value="1">Team</option>
                      <option value="2">Admin</option>
                      <option value="0"><?php echo MEMBER; ?></option>
                      <?php
                    } else if(getAccountRank($_GET["user"]) == 0){
                      ?>
                      <option value="0"><?php echo MEMBER; ?></option>
                      <option value="1">Team</option>
                      <option value="2">Admin</option>
                      <?php
                    }
                     ?>
                  </select>
                  <button type="submit" name="submit">Save</button>
                </form>
              <?php
            } else {
              ?>
              <div class="error">
                <?php echo EDIT_NOT_YOU; ?>
              </div>
              <?php
            }
          } else {
            ?>
            <div class="error">
              <?php echo EDIT_NO_PERMS; ?>
            </div>
            <?php
          }
        } else {
          ?>
          <div class="error">
            <?php echo NO_REQUEST; ?>
          </div>
          <?php
        }
         ?>
      </div>
    </div>
  </body>
</html>
