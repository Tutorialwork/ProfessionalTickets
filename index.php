<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
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

    include('database.php');
    $abfrage = "CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `message` varchar(25000) NOT NULL,
  `answer` varchar(25000) NOT NULL,
  `status` int(6) NOT NULL,
  `ticketauthor` varchar(255) NOT NULL,
  `answerauthor` varchar(255) NOT NULL,
  `created_at` varchar(255)
);";
    $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));

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

      <?php

      $site = file_get_contents('http://tutorialwork.bplaced.net/update/web/ProfessionalTickets.html');
      $currentversion = "1.2";
      if($currentversion != $site){
        $user = $_SESSION["username"];
        $abfrage = "SELECT * FROM users WHERE username = '$user'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        while($row = mysqli_fetch_array($ergebnis)){
          if($row["rank"] == 2){
            echo '<div class="ui warning message">
      <div class="header">
        Update available
      </div>
      <p>A new update is available for ProfessionalTickets. <a href="http://tutorialwork.bplaced.net/update/web/dlurl/dlprofessionaltickets.php">UPDATE NOW</a></p></div>';
          }
        }
      }

       ?>

    <h1>Dashboard</h1>
    <p>This is the center of your profile. Here can you see important stats, data and links.</p>
    <br>
    <div class="ui card">
  <div class="content">
    <div class="header"><?php echo $_SESSION["username"] ?></div>
    <div class="meta">Account created at: <?php
    $user = $_SESSION["username"];
    $abfrage = "SELECT reg_at FROM users WHERE username = '$user'";
    $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
    while($row = mysqli_fetch_array($ergebnis)){
      echo date('Y-m-d H:i', $row["reg_at"]);
    }
     ?></div>
    <div class="description">
      <p>Your rank: <strong>
      <?php
      $user = $_SESSION["username"];
      $abfrage = "SELECT rank FROM users WHERE username = '$user'";
      $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
      while($row = mysqli_fetch_array($ergebnis)){
        if($row["rank"] == 0){
          echo "Member";
        } else if($row["rank"] == 1){
          echo "Team";
        } else if($row["rank"] == 2){
          echo "Admin";
        }
      }
       ?></strong></p>
    </div>
  </div>
</div>
    <br>
    <h1>Stats</h1>
    <div class="ui statistics">
      <div class="statistic">
        <div class="value">
          <?php

          include('database.php');
          $user = $_SESSION["username"];
          $abfrage = "SELECT ticketauthor FROM tickets WHERE ticketauthor = '$user'";
          $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
          $data = 0;
          while($row = mysqli_fetch_array($ergebnis)){
            $data++;
          }

          echo $data;

          ?>
        </div>
        <div class="label">
          your tickets
        </div>
      </div>
      <div class="statistic">
        <div class="value">
          <?php

          include('database.php');
          $user = $_SESSION["username"];
          $abfrage = "SELECT * FROM users WHERE username = '$user'";
          $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
          $data = 0;
          while($row = mysqli_fetch_array($ergebnis)){
            echo $row["answers"];
          }

          ?>
        </div>
        <div class="label">
          your answers
        </div>
      </div>
      <div class="statistic">
        <div class="value">
          <?php

          include('database.php');
          $abfrage = "SELECT * FROM tickets;";
          $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
          $data = 0;
          while($row = mysqli_fetch_object($ergebnis)){
            $data++;
          }

          echo $data;

          ?>
        </div>
        <div class="label">
          globale tickets
        </div>
      </div>
      <div class="statistic">
        <div class="value">
          <?php

          include('database.php');
          $abfrage = "SELECT answers FROM users;";
          $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
          $data = 0;
          while($row = mysqli_fetch_array($ergebnis)){
              $data += $row["answers"];
          }

          echo $data;

          ?>
        </div>
        <div class="label">
          globale answers
        </div>
      </div>
    </div>

      </div>
  </body>
</html>
