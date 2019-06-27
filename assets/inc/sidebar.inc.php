<?php
if(isset($_SESSION["username"])){
  ?>
  <h1><?php echo SIDEBAR_WELCOME; ?> <?php echo $_SESSION["username"]; ?></h1>
  <ul>
    <?php
    if(getAccountRank($_SESSION["username"]) > 1){
      ?>
      <li><a href="admin.php">Admin</a></li>
      <hr>
      <?php
    }
     ?>
    <?php
    if(getAccountRank($_SESSION["username"]) > 0){
      ?>
      <li><a href="team.php"><?php echo SIDEBAR_OPENTICKET; ?></a></li>
      <hr>
      <?php
    }
     ?>
    <li><a href="mytickets.php"><?php echo SIDEBAR_MYTICKETS; ?></a></li>
    <hr>
    <li><a href="faq.php">FAQ</a></li>
    <hr>
    <li><a href="settings.php"><?php echo SIDEBAR_ACCSETTINGS ?></a></li>
    <hr>
    <li><a href="logout.php"><?php echo SIDEBAR_LOGOUT ?></a></li>
  </ul>
  <?php
} else {
  ?>
  <h1><?php echo SIDEBAR_WELCOME_GUEST; ?></h1>
  <p><?php echo SIDEBAR_WELCOME_GUEST_TEXT; ?></p><br>
  <form action="login.php" method="get">
    <button type="submit" name="index"><?php echo LOGIN; ?></button>
  </form>
  <?php
}
 ?>
