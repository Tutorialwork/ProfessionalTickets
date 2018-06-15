<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Accountoptions</title>
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

    <h1>Accountoptions</h1>
    <p>On this page you can modify accounts.</p>
    <br>

    <?php

    if(isset($_GET["rank"])){
      if(isset($_GET["id"])){
        if(isset($_GET["rank"])){
          $id = $_GET["id"];
          $rank = $_GET["rank"];
          if($rank < 3){
            $abfrage = "UPDATE users SET rank = '$rank' WHERE id = '$id'";
            $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
            if($ergebnis){
              echo '<div class="ui container">
              <div class="ui success message">
        <div class="header">
          Success
        </div>
        <p>The rank from the user was changed.
      </p></div></div>';
            }
          }
        }
      }
    }

    if(isset($_GET["rm"])){
      if(isset($_GET["id"])){
        $id = $_GET["id"];
        $abfrage = "DELETE FROM users WHERE id = '$id'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        if($ergebnis){
          echo '<div class="ui container">
          <div class="ui success message">
    <div class="header">
      Success
    </div>
    <p>The user was deleted.
  </p></div></div>';
        }
      }
    }

    if(isset($_GET["ban"])){
      if(isset($_GET["id"])){
        $id = $_GET["id"];
        $abfrage = "UPDATE users SET ban = '1' WHERE id = '$id'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        if($ergebnis){
          echo '<div class="ui container">
          <div class="ui success message">
    <div class="header">
      Success
    </div>
    <p>The user was banned.
  </p></div></div>';
        }
      }
    }

    if(isset($_GET["unban"])){
      if(isset($_GET["id"])){
        $id = $_GET["id"];
        $abfrage = "UPDATE users SET ban = '0' WHERE id = '$id'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        if($ergebnis){
          echo '<div class="ui container">
          <div class="ui success message">
    <div class="header">
      Success
    </div>
    <p>The user was unbanned.
  </p></div></div>';
        }
      }
    }

    if(isset($_GET["activate"])){
      if(isset($_GET["id"])){
        $id = $_GET["id"];
        $abfrage = "UPDATE users SET status = '0' WHERE id = '$id'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        if($ergebnis){
          echo '<div class="ui container">
          <div class="ui success message">
    <div class="header">
      Success
    </div>
    <p>The user was activated.
  </p></div></div>';
        }
      }
    }

    if(isset($_GET["edit"])){
      if(isset($_GET["id"])){
        include('database.php');
        $id = $_GET["id"];
        $abfrage = "SELECT * FROM users WHERE id = '$id'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        while($row = mysqli_fetch_array($ergebnis)){
          echo '<h1>'.$row["username"].' #'.$row["id"].'</h1>';
          echo "<p>Rank: <strong>";

          if($row["rank"] == 0){
            echo "Member ";
            echo '<a href="accoptions.php?rank&id='.$row["id"].'&rank=1" class="ui primary button">
            Change Rank to Team
            </a>';
            echo '<a href="accoptions.php?rank&id='.$row["id"].'&rank=2" class="ui primary button">
            Change Rank to Admin
            </a>';
          } else if($row["rank"] == 1){
            echo "Team ";
            echo '<a href="accoptions.php?rank&id='.$row["id"].'&rank=0" class="ui primary button">
            Change Rank to Member
            </a>';
            echo '<a href="accoptions.php?rank&id='.$row["id"].'&rank=2" class="ui primary button">
            Change Rank to Admin
            </a>';
          } else if($row["rank"] == 2){
            echo "Admin ";
            echo '<a href="accoptions.php?rank&id='.$row["id"].'&rank=1" class="ui primary button">
            Change Rank to Team
            </a>';
            echo '<a href="accoptions.php?rank&id='.$row["id"].'&rank=0" class="ui primary button">
            Change Rank to Member
            </a>';
          }

          echo '</strong></p>';

          if($row["status"] != 0){
            echo '<a href="accoptions.php?activate&id='.$row["id"].'" class="ui green button">
        Activate account
      </a>';
          }

          if($row["ban"] == 0){
            echo '<a href="accoptions.php?ban&id='.$row["id"].'" class="ui red button">
        Ban
      </a>';
          } else {
            echo '<a href="accoptions.php?unban&id='.$row["id"].'" class="ui green button">
        Unban
      </a>';
          }

          echo '<a href="accoptions.php?rm&id='.$row["id"].'" class="ui red button">
      Delete
    </a>';
        }
      }
    }

    if(empty($_GET)){
      echo '<div class="ui container">
      <div class="ui error message">
<div class="header">
  Error
</div>
<p>No request was send.
</p></div></div>';
    }

     ?>

      </div>
  </body>
</html>
