<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Change Password</title>
    <link rel="stylesheet" type="text/css" href="lib/semantic.min.css">
    <script
      src="https://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous"></script>
    <script src="lib/semantic.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
  </head>
  <body>

    <!-- ProfessionalTickets by Tutorialwork -->

    <?php

    session_start();
    if(!isset($_SESSION['username'])){
      header("Location: login.php");
      exit;
    }

     ?>

    <div class="ui huge menu">
      <a class="item active" href="index.php">
        Home
      </a>
      <a class="item" href="addticket.php">
        Write a ticket
      </a>
      <a class="item" href="tickets.php">
        Tickets
      </a>
      <?php
      include('database.php');
      $user = $_SESSION["username"];
      $abfrage = "SELECT * FROM users WHERE username = '$user'";
      $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
      while($row = mysqli_fetch_array($ergebnis)){
        if($row["rank"] == 2){
          echo '<a class="item" href="accounts.php">
            Accounts
          </a>';
        }
      }
       ?>
      <div class="right menu">
        <a class="item" href="user.php">
          <?php echo $_SESSION['username'] ?>
        </a>
        <div class="item">
            <a class="ui primary button" href="logout.php">Logout</a>
        </div>
      </div>
    </div>

    <div class="ui container">
    <h1>Change password</h1>
    <p>Her can you change your password if you know you current password.</p>
    <br>

    <?php

    if(isset($_GET["change"])){
      $user = $_SESSION["username"];
      $opw = $_POST["opw"];
      $npw = $_POST["npw"];
      $npw2 = $_POST["rnpw"];
      if($npw == $npw2){
        include('database.php');
        $abfrage = "SELECT * FROM users WHERE username = '$user'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        while($row = mysqli_fetch_array($ergebnis)){
          $hashpw = $row["password"];
          if(password_verify($opw, $hashpw)){
            $pwtohash = password_hash($npw, PASSWORD_BCRYPT);
            $abfrage = "UPDATE users SET password = '$pwtohash' WHERE username = '$user'";
            $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
            echo '<div class="ui success message">
      <div class="header">
        Success
      </div>
      <p>Your password is changed.
      </p></div>';
          } else {
            echo '<div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>Your old password is incorrect.
      </p></div>';
          }
        }
      } else {
        echo '<div class="ui negative message">
  <div class="header">
    Error
  </div>
  <p>The passwords do not match.
  </p></div>';
      }
    }

     ?>

    <form class="ui form" action="user.php?change" method="post">
    <div class="field">
      <label>Old password</label>
      <input type="password" name="opw" placeholder="Old password" required>
    </div>
    <div class="field">
      <label>New password</label>
      <input type="password" name="npw" placeholder="New password" required>
    </div>
    <div class="field">
      <label>New password confirm</label>
      <input type="password" name="rnpw" placeholder="New password confirm" required>
    </div>
    <button class="ui button" type="submit">Change</button>
  </form>

      </div>
  </body>
</html>
