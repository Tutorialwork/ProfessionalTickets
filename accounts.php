<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Accounts</title>
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
      <a class="item" href="index.php">
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
          echo '<a class="item active" href="accounts.php">
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

    <?php

    $user = $_SESSION["username"];
    $abfrage = "SELECT * FROM users WHERE username = '$user'";
    $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
    while($row = mysqli_fetch_array($ergebnis)){
      if($row["rank"] != 2){
        echo '<div class="ui negative message">
  <div class="header">
    Error
  </div>
  <p>You are not authorized to access this page.
  </p></div>';
        exit;
      }
    }

    ?>

    <h1>Accounts</h1>
    <p>Here can you manage all accounts.</p>
    <br>

    <table class="ui celled table">
<thead>
  <tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>Rank</th>
    <th>Ban</th>
    <th>Answers</th>
    <th>Status</th>
    <th>Joined at</th>
  </tr>
</thead>
<tbody>

  <?php

  include('database.php');
  $abfrage = "SELECT * FROM users";
  $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
  while($row = mysqli_fetch_array($ergebnis)){
    echo '<tr>
    <td>'.$row["id"].'</td>
    <td>'.$row["username"].'</td>
    <td>'.$row["email"].'</td>';

    if($row["rank"] == 0){
      echo "<td>Member</td>";
    } else if($row["rank"] == 1){
      echo "<td>Team</td>";
    } else if($row["rank"] == 2){
      echo "<td>Admin</td>";
    }

    $time = date('Y-m-d H:i:s',$row["reg_at"]);

    if($row["ban"] == 0){
      echo "<td>Unbanned</td>";
    } else {
      echo "<td>Banned</td>";
    }

    echo '<td>'.$row["answers"].'</td>';

    if($row["status"] == 0){
      echo "<td>Activated</td>";
    } else {
      echo "<td>Disabled</td>";
    }

    echo '<td>'.$time.' <a href="accoptions.php?edit&id='.$row["id"].'" class="ui primary button">
  Edit
  </a></td>
  </tr>';
  }

   ?>

      </div>
  </body>
</html>
