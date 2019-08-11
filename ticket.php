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
} else if($_SESSION["username"] != getAccountName(getTicketCreatorID($_GET["id"]))){
  if(getAccountRank($_SESSION["username"]) < 1){
    ?>
    <meta http-equiv="refresh" content="0; URL=mytickets.php">
    <?php
    exit;
  }
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ticket</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
  </head>
  <body>
    <div class="flex">
      <div class="flex-item">
        <?php
        if(isset($_GET["id"])){
          require("mysql.php");
          if(isset($_GET["close"])){
            if(!isTicketClosed($_GET["id"])){
              $stmt = $mysql->prepare("UPDATE tickets SET STATUS = 1 WHERE ID = :id");
              $stmt->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
              $stmt->execute();
              ?>
              <div class="success">
                <?php echo TICKET_CLOSED_SUCCESS; ?>
              </div>
              <?php
            } else {
              ?>
              <div class="error">
                <?php echo TICKET_ALREADY_CLOSED; ?>
              </div>
              <?php
            }
          }
          if(isset($_POST["submit"])){
            if(!isTicketClosed($_GET["id"])){
              $stmt = $mysql->prepare("INSERT INTO answers (TICKET, CREATOR, ANSWER, ANSWERDATE) VALUES
                (:ticketid, :accid, :msg, :now)");
              $stmt->bindParam(":ticketid", $_GET["id"], PDO::PARAM_INT);
              $stmt->bindParam(":accid", getAccountID($_SESSION["username"]), PDO::PARAM_INT);
              $stmt->bindParam(":msg", $_POST["answer"], PDO::PARAM_STR);
              $now = time();
              $stmt->bindParam(":now", $now, PDO::PARAM_STR);
              $stmt->execute();
              $stmt2 = $mysql->prepare("UPDATE tickets SET LASTANSWERDATE = :now WHERE ID = :id");
              $stmt2->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
              $now = time();
              $stmt2->bindParam(":now", $now, PDO::PARAM_STR);
              $stmt2->execute();
              ?>
              <div class="success">
                <?php echo TICKET_POSTED; ?>
              </div>
              <?php
            } else {
              ?>
              <div class="error">
                <?php echo TICKET_POSTED_ERR; ?>
              </div>
              <?php
            }
          }
          ?>
          <h1><?php echo getTicketTitle($_GET["id"]) ?></h1>
          <p><?php echo getTicketContent($_GET["id"]); ?></p>
          <br>
          <p><?php echo CREATED_AT; ?>: <?php echo displayTimestamp(getTicketDate($_GET["id"])) ?><br>
          <?php echo CREATED_BY; ?>: <?php echo getAccountName(getTicketCreatorID($_GET["id"])); ?></p>
          <hr><br>
          <?php
          if(!isTicketClosed($_GET["id"])){
            ?>
           <a href="ticket.php?id=<?php echo $_GET["id"]; ?>&close" class="btn"><?php echo CLOSE_BTN; ?></a>
           <?php
          } else {
            ?>
            <div class="error">
              <?php echo TICKET_CLOSED; ?>
            </div>
            <?php
          }
        } else {
          ?>
          <div class="error">
            <?php echo TICKET_ERROR; ?>
          </div>
          <?php
        }
         ?>
      </div>
      <div class="flex-item sidebar">
        <?php require('assets/inc/sidebar.inc.php'); ?>
      </div>
    </div>
    <?php
    $stmt = $mysql->prepare("SELECT * FROM answers WHERE TICKET = :id");
    $stmt->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->rowCount();
    if($count > 0){
      while ($row = $stmt->fetch()) {
        ?>
        <div class="flex">
          <div class="flex-item">
            <?php
            echo '<img src="https://minotar.net/helm/'.getAccountName($row["CREATOR"]).'/64.png" class="head">';
             ?>
            <p><?php echo $row["ANSWER"]; ?></p>
            <p class="detail"><?php echo getAccountName($row["CREATOR"]); ?> - <?php echo displayTimestamp($row["ANSWERDATE"]); ?></p>
          </div>
        </div>
        <?php
      }
    }
    if(!isTicketClosed($_GET["id"])){
      ?>
      <div class="flex">
        <div class="flex-item">
          <h1><?php echo TICKET_ANSWER_HEADING; ?></h1>
          <form action="ticket.php?id=<?php echo $_GET["id"]; ?>" method="post">
            <textarea name="answer" rows="8" cols="80" minlength="16"></textarea>
            <button type="submit" name="submit"><?php echo POST; ?></button>
          </form>
        </div>
      </div>
      <?php
    }
     ?>
  </body>
</html>
