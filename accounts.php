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
} else if(!getAccountRank($_SESSION["username"]) > 1){
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
    <title>Accounts</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/jquery.sweet-modal.min.css" />
    <script src="assets/js/jquery.sweet-modal.min.js"></script>
  </head>
  <body>
    <div class="flex">
      <div class="flex-item">
        <script type="text/javascript">
        function openConfirm(name){
          $.sweetModal.confirm('Do you want to delete <strong>'+name+'</strong>?', function() {
            var request = new XMLHttpRequest();
            request.open('post', 'ajax.php?del', true);
            request.send("name="+name);
            $.sweetModal({
	             content: '<strong>'+name+'</strong> was successfully deleted!',
	             icon: $.sweetModal.ICON_SUCCESS
             });
          });
        }
        </script>
        <h1>Accounts</h1>
        <?php
        require("mysql.php");
        $stmt = $mysql->prepare("SELECT * FROM accounts");
        $stmt->execute();
        ?>
        <table>
          <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Last login</th>
            <th>First login</th>
            <th>Rank</th>
            <th>Action</th>
          </tr>
          <?php
          while ($row = $stmt->fetch()) {
            ?>
            <tr>
              <td><?php echo $row["USERNAME"]; ?></td>
              <td><?php echo $row["EMAIL"]; ?></td>
              <td><?php echo displayTimestamp($row["LASTLOGIN"]); ?></td>
              <td><?php echo displayTimestamp($row["FIRSTLOGIN"]); ?></td>
              <td><?php
              if(getAccountRank($row["USERNAME"]) == 0){
                echo "User";
              } if(getAccountRank($row["USERNAME"]) == 1){
                echo "Team";
              } else {
                echo "Admin";
              }
               ?></td>
              <td><?php
              if(!getAccountRank($row["USERNAME"]) == 3){
                ?>
                <button onclick="openConfirm('<?php echo $row["USERNAME"]; ?>');" class="btn"><i class="fas fa-trash"></i></button>
                <?php
              }
               ?>
               <button onclick="openConfirm('<?php echo $row["USERNAME"]; ?>');" class="btn"><i class="fas fa-trash"></i></button>

             </td>
            </tr>
            <?php
          }
           ?>
        </table>
      </div>
      <div class="flex-item sidebar">
        <?php require('assets/inc/sidebar.inc.php'); ?>
      </div>
    </div>
  </body>
</html>
