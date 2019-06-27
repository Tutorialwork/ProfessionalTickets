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
function create(){
  require("mysql.php");
  $stmt = $mysql->prepare("INSERT INTO tickets (CREATOR, TITLE, CATEGORY, MESSAGE, CREATIONDATE, LASTANSWERDATE, STATUS)
  VALUES (:accid, :title, :catid, :msg, :now, null, 0)");
  $id = getAccountID($_SESSION["username"]);
  $stmt->bindParam(":accid", $id, PDO::PARAM_INT);
  $stmt->bindParam(":title", $_POST["subject"], PDO::PARAM_STR);
  $stmt->bindParam(":catid", $_POST["category"], PDO::PARAM_INT);
  $stmt->bindParam(":msg", $_POST["msg"], PDO::PARAM_STR);
  $now = time();
  $stmt->bindParam(":now", $now, PDO::PARAM_STR);
  $stmt->execute();
  ?>
  <meta http-equiv="refresh" content="0; URL=mytickets.php">
  <?php
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo TICKET_CREATE_HEADING; ?></title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </head>
  <body>
    <div class="flex">
      <div class="flex-item">
        <?php
        if(isset($_POST["submit"])){
          if(getSetting("captcha") == "1"){
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array(
              'secret' => getSetting("captcha_private"),
              'response' => $_POST["g-recaptcha-response"]
            );
            $options = array(
              'http' => array (
                'method' => 'POST',
                'content' => http_build_query($data)
              )
            );
            $context  = stream_context_create($options);
            $verify = file_get_contents($url, false, $context);
            $captcha_success=json_decode($verify);
            if($captcha_success->success){
              create();
            } else {
              ?>
              <div class="error">
                <?php echo CAPTCHA_FAIL; ?>
              </div>
              <?php
            }
          } else {
            create();
          }
        }
         ?>
        <h1><?php echo TICKET_CREATE_HEADING; ?></h1>
        <form action="createticket.php" method="post">
          <select name="category">
            <?php
            require("mysql.php");
            $stmt = $mysql->prepare("SELECT * FROM categorys WHERE STATUS = 0");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
              ?>
              <option value="<?php echo $row["ID"]; ?>"><?php echo $row["NAME"]; ?></option>
              <?php
            }
             ?>
          </select>
          <input type="text" name="subject" placeholder="<?php echo SUBJECT; ?>" minlength="3" required><br>
          <textarea name="msg" rows="8" cols="80" placeholder="<?php echo MESSAGE; ?>" minlength="16" required></textarea><br>
          <?php
          if(getSetting("captcha") == "1"){
            ?>
            <div class="g-recaptcha" data-sitekey="<?php echo getSetting("captcha_public"); ?>"></div><br>
            <?php
          }
           ?>
          <button type="submit" name="submit"><?php echo SEND; ?></button><br>
        </form>
      </div>
      <div class="flex-item sidebar">
        <?php require('assets/inc/sidebar.inc.php'); ?>
      </div>
    </div>
  </body>
</html>
