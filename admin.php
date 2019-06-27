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
    <title>Admin</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  </head>
  <body>
    <div class="flex">
      <div class="flex-item">
        <?php
        if(isset($_GET["delcat"])){
          require("mysql.php");
          $stmt = $mysql->prepare("SELECT * FROM categorys WHERE ID = :id");
          $stmt->bindParam(":id", $_GET["delcat"], PDO::PARAM_INT);
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count != 0){
            $stmt = $mysql->prepare("UPDATE categorys SET STATUS = 1 WHERE ID = :id");
            $stmt->bindParam(":id", $_GET["delcat"], PDO::PARAM_INT);
            $stmt->execute();
            ?>
            <div class="success">
              <?php echo CAT_DEL; ?>
            </div>
            <?php
          } else {
            ?>
            <div class="error">
              <?php echo ERROR; ?>
            </div>
            <?php
          }
        }
         ?>
        <h1><?php echo CATEGORYS; ?></h1>
        <div class="icon-card">
          <a href="addcategory.php"><i class="fas fa-plus-square fa-2x"></i></a>
        </div>
        <?php
        require("mysql.php");
        $stmt = $mysql->prepare("SELECT * FROM categorys WHERE STATUS = 0");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count != 0){
          ?>
          <table>
            <tr>
              <th>Name</th>
              <th><?php echo ACTION; ?></th>
            </tr>
            <?php
            while ($row = $stmt->fetch()) {
              ?>
              <tr>
                <td><?php echo $row["NAME"]; ?></td>
                <td><a href="admin.php?delcat=<?php echo $row["ID"]; ?>" class="btn"><i class="far fa-trash-alt"></i></a></td>
              </tr>
              <?php
            }
          }
             ?>
          </table>
      </div>
      <div class="flex-item">
        <?php
        if(isset($_GET["delfaq"])){
          require("mysql.php");
          $stmt = $mysql->prepare("SELECT * FROM faq WHERE ID = :id");
          $stmt->bindParam(":id", $_GET["delfaq"], PDO::PARAM_INT);
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count != 0){
            $stmt = $mysql->prepare("DELETE FROM faq WHERE  ID = :id");
            $stmt->bindParam(":id", $_GET["delfaq"], PDO::PARAM_INT);
            $stmt->execute();
            ?>
            <div class="success">
              <?php echo FAQ_DEL; ?>
            </div>
            <?php
          } else {
            ?>
            <div class="error">
              <?php echo ERROR; ?>
            </div>
            <?php
          }
        }
         ?>
        <h1>FAQ</h1>
        <div class="icon-card">
          <a href="addfaq.php"><i class="fas fa-plus-square fa-2x"></i></a>
        </div>
        <?php
        require("mysql.php");
        $stmt = $mysql->prepare("SELECT * FROM faq");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count != 0){
          ?>
          <table>
            <tr>
              <th><?php echo QUESTION; ?></th>
              <th><?php echo ANSWER; ?></th>
              <th><?php echo ACTION; ?></th>
            </tr>
            <?php
            while ($row = $stmt->fetch()) {
              ?>
              <tr>
                <td><?php echo $row["QUESTION"]; ?></td>
                <td><?php echo $row["ANSWER"]; ?></td>
                <td><a href="admin.php?delfaq=<?php echo $row["ID"]; ?>" class="btn"><i class="far fa-trash-alt"></i></a></td>
              </tr>
              <?php
            }
          } else {
            ?>
            <div class="error">
              <?php echo NOFAQ; ?>
            </div>
            <?php
          }
             ?>
          </table>
      </div>
      <div class="flex-item sidebar">
        <?php require('assets/inc/sidebar.inc.php'); ?>
      </div>
    </div>
    <div class="flex">
      <div class="flex-item">
        <h1>Accounts</h1>
        <?php
        require("mysql.php");
        $stmt = $mysql->prepare("SELECT * FROM accounts");
        $stmt->execute();
        $count = $stmt->rowCount();
        if($count != 0){
          ?>
          <table>
            <tr>
              <th>ID</th>
              <th><?php echo USERNAME; ?></th>
              <th>Email</th>
              <th><?php echo RANK; ?></th>
              <th><?php echo ACTION; ?></th>
            </tr>
            <?php
            while ($row = $stmt->fetch()) {
              ?>
              <tr>
                <td><?php echo $row["ID"]; ?></td>
                <td><?php echo $row["USERNAME"]; ?></td>
                <td><?php echo $row["EMAIL"]; ?></td>
                <td><?php
                if(getAccountRank($row["USERNAME"]) == 3 || getAccountRank($row["USERNAME"]) == 2){
                  echo "Admin";
                } else if(getAccountRank($row["USERNAME"]) == 2){
                  echo "Team";
                } else if(getAccountRank($row["USERNAME"]) == 1){
                  echo MEMBER;
                }
                 ?></td>
                 <td><a href="editaccount.php?user=<?php echo $row["USERNAME"]; ?>" class="btn"><i class="far fa-edit"></i></a></td>
              </tr>
              <?php
            }
          }
             ?>
          </table>
      </div>
      <div class="flex-item">
        <?php
        if(isset($_POST["submit"])){
          setSetting("lang", $_POST["lang"]);
          setSetting("captcha", $_POST["captcha"]);
          setSetting("captcha_public", $_POST["captcha-public"]);
          setSetting("captcha_private", $_POST["captcha-secret"]);
          ?>
          <div class="success">
            <?php echo SAVED; ?>
          </div>
          <?php
        }
         ?>
        <h1><?php echo SETTINGS; ?></h1>
        <form action="admin.php" method="post">
          <select name="lang">
            <?php
            if(getSetting("lang") == "en"){
              ?>
              <option value="en">English</option>
              <option value="de">German (Deutsch)</option>
              <?php
            } else {
              ?>
              <option value="de">German (Deutsch)</option>
              <option value="en">English</option>
              <?php
            }
             ?>
          </select>
          <h3>Captcha</h3>
          <select name="captcha">
            <?php
            if(getSetting("captcha") == "0"){
              ?>
              <option value="0"><?php echo DISABLED; ?></option>
              <option value="1"><?php echo ENABLED; ?></option>
              <?php
            } else {
              ?>
              <option value="1"><?php echo ENABLED; ?></option>
              <option value="0"><?php echo DISABLED; ?></option>
              <?php
            }
             ?>
          </select>
          <?php
          $publickey = getSetting("captcha_public");
          $privatekey = getSetting("captcha_private");
           ?>
          <p><?php echo CAPTCHA_HINT; ?></p>
          <input type="text" name="captcha-public" placeholder="<?php echo CAPTCHA_PUBLIC_KEY ?>" value="<?php echo $publickey; ?>"><br>
          <input type="text" name="captcha-secret" placeholder="<?php echo CAPTCHA_PRIVATE_KEY; ?>" value="<?php echo $privatekey; ?>"><br>
          <button type="submit" name="submit"><?php echo SAVE; ?></button>
        </form>
      </div>
    </div>
  </body>
</html>
