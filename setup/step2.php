<?php
if(file_exists("../mysql.php")){
  header("Location: ../index.php");
  exit;
}
session_start();
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
        <?php
        if(isset($_SESSION["host"]) && isset($_SESSION["database"]) &&
        isset($_SESSION["user"]) && isset($_SESSION["password"])){
          if(isset($_POST["submit"])){
            if($_POST["password"] == $_POST["password2"]){
              require("../MinecraftUUID.php");
              $profile = ProfileUtils::getProfile($_POST["username"]);
              if ($profile != null) {
                $result = $profile->getProfileAsArray();
                $uuid = ProfileUtils::formatUUID($result['uuid']);
              }
              if($uuid != null){
                $host = $_SESSION["host"];
                $name = $_SESSION["database"];
                $user = $_SESSION["user"];
                $passwort = $_SESSION["password"];
                /////////////////////////////////////////////////
                try{
                    $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $passwort);
                    $stmt = $mysql->prepare("CREATE TABLE IF NOT EXISTS accounts(ID int(11) UNIQUE AUTO_INCREMENT,
                      UUID varchar(64),
                      USERNAME varchar(255),
                      EMAIL varchar(255),
                      PASSWORD varchar(255),
                      LASTLOGIN varchar(255),
                      FIRSTLOGIN varchar(255),
                      ACCOUNTRANK int(11));
                    ");
                    $stmt->execute();
                    $stmt2 = $mysql->prepare("CREATE TABLE IF NOT EXISTS settings (
                      NAME VARCHAR(255) UNIQUE,
                      VALUE VARCHAR(255)
                    )");
                    $stmt2->execute();
                    $stmt3 = $mysql->prepare("CREATE TABLE IF NOT EXISTS tickets (
                      ID INT(11) UNIQUE AUTO_INCREMENT,
                      CREATOR INT(11),
                      TITLE VARCHAR(1055),
                      CATEGORY INT(11),
                      MESSAGE VARCHAR(14500),
                      CREATIONDATE VARCHAR(255),
                      LASTANSWERDATE VARCHAR(255),
                      STATUS INT(11)
                    )");
                    $stmt3->execute();
                    $stmt4 = $mysql->prepare("CREATE TABLE IF NOT EXISTS categorys (
                      ID INT(11) UNIQUE AUTO_INCREMENT,
                      NAME VARCHAR(255),
                      STATUS INT(11)
                    )");
                    $stmt4->execute();
                    $stmt5 = $mysql->prepare("CREATE TABLE IF NOT EXISTS answers (
                      ID INT(11) UNIQUE AUTO_INCREMENT,
                      TICKET INT(11),
                      CREATOR INT(11),
                      ANSWER VARCHAR(14500),
                      ANSWERDATE VARCHAR(255)
                    )");
                    $stmt5->execute();
                    $stmt6 = $mysql->prepare("CREATE TABLE IF NOT EXISTS faq (
                      ID INT(11) UNIQUE AUTO_INCREMENT,
                      QUESTION VARCHAR(5000),
                      ANSWER VARCHAR(10000)
                    )");
                    $stmt6->execute();
                    $acc = $mysql->prepare("INSERT INTO accounts (UUID, USERNAME, EMAIL, PASSWORD, LASTLOGIN, FIRSTLOGIN, ACCOUNTRANK)
                    VALUES (:uuid, :user, :email, :pw, :now, :now, 3)");
                    $acc->bindParam(":uuid", $uuid, PDO::PARAM_STR);
                    $acc->bindParam(":user", $_POST["username"], PDO::PARAM_STR);
                    $acc->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
                    $hash = password_hash($_POST["password"], PASSWORD_BCRYPT);
                    $acc->bindParam(":pw", $hash, PDO::PARAM_STR);
                    $acc->bindParam(":now", time(), PDO::PARAM_STR);
                    $acc->execute();
                    $settings1 = $mysql->prepare("INSERT INTO settings (NAME, VALUE) VALUES ('lang', 'en')");
                    $settings2 = $mysql->prepare("INSERT INTO settings (NAME, VALUE) VALUES ('captcha', '0')");
                    $settings3 = $mysql->prepare("INSERT INTO settings (NAME, VALUE) VALUES ('captcha_public', null)");
                    $settings4 = $mysql->prepare("INSERT INTO settings (NAME, VALUE) VALUES ('captcha_private', null)");
                    $settings1->execute();
                    $settings2->execute();
                    $settings3->execute();
                    $settings4->execute();
                    $cat1 = $mysql->prepare("INSERT INTO categorys (NAME, STATUS) VALUES ('Question', 0)");
                    $cat2 = $mysql->prepare("INSERT INTO categorys (NAME, STATUS) VALUES ('Report', 0)");
                    $cat3 = $mysql->prepare("INSERT INTO categorys (NAME, STATUS) VALUES ('Bugreport', 0)");
                    $cat4 = $mysql->prepare("INSERT INTO categorys (NAME, STATUS) VALUES ('Problem', 0)");
                    $cat5 = $mysql->prepare("INSERT INTO categorys (NAME, STATUS) VALUES ('Other', 0)");
                    $cat1->execute();
                    $cat2->execute();
                    $cat3->execute();
                    $cat4->execute();
                    $cat5->execute();
                    $faq1 = $mysql->prepare("INSERT INTO faq (QUESTION, ANSWER) VALUES ('Where I can edit the FAQ?', 'Login into your account and go to the admin panel. In the admin panel can you manage the FAQ entries.')");
                    $faq1->execute();
                    ?>
                    <meta http-equiv="refresh" content="0; URL=step3.php">
                    <?php
                    exit;
                } catch (PDOException $e){
                    ?>
                    <div class="error">
                      Unable to connect to the MySQL database.
                    </div>
                    <?php
                }
              } else {
                ?>
                <div class="error">
                  Your Minecraft username is not correct.
                </div>
                <?php
              }
            } else {
              ?>
              <div class="error">
                Your passwords are not the same.
              </div>
              <?php
            }
          }
        } else {
          header("Location: index.php");
          exit;
        }
         ?>
        <h1>Setup</h1>
        <p>Please create now an admin account.</p>
        <form action="step2.php" method="post">
          <input type="text" name="username" placeholder="Minecraft Username" minlength="3" maxlength="16" required>
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="password" placeholder="Password" minlength="6" required>
          <input type="password" name="password2" placeholder="Repeat your password" minlength="6" required>
          <button type="submit" name="submit">Continue</button>
        </form>
      </div>
    </div>
  </body>
</html>
