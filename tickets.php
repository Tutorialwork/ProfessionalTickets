<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Tickets</title>
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
      <a class="item active" href="tickets.php">
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

      include('database.php');
      $user = $_SESSION['username'];
      $abfrage = "SELECT * FROM users WHERE username = '$user'";
      $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
      while($row = mysqli_fetch_array($ergebnis)){
        $rank = $row["rank"];
        if($row["rank"] == 1){
          echo '<a href="tickets.php?opened" class="ui button">
            Show all open tickets
          </a>';
        } else if($row["rank"] == 2){
          echo '<a href="tickets.php?opened" class="ui button">
            Show all open tickets
          </a>';
          echo '<a href="tickets.php?all" class="ui button">
            Show all tickets
          </a>';
        }
      }

      if(isset($_GET['all'])){
        if($rank != 0){
          echo '<h1>All tickets</h1>
          <p>Here can you see all the tickets.</p>
          <br>

          <table class="ui celled table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Category</th>
          <th>Status</th>
          <th>Created at</th>
        </tr>
      </thead>
      <tbody>';
      include('database.php');
      $abfrage = "SELECT * FROM tickets";
      $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
      while($row = mysqli_fetch_array($ergebnis)){
        echo '<tr>
        <td>'.$row["id"].'</td>
        <td>'.$row["title"].'</td>
        <td>'.$row["category"].'</td>';

        if($row["status"] == 0){
          echo "<td>Opened</td>";
        } else if($row["status"] == 1){
          echo "<td>Closed</td>";
        } else if($row["status"] == 2){
          echo "<td>Closed by user</td>";
        }

        $time = date('Y-m-d H:i:s',$row["created_at"]);

        echo '<td>'.$time.' <a href="ticket.php?id='.$row["id"].'" class="ui primary button">
    View
  </a><a href="ticket.php?rm&id='.$row["id"].'" class="ui red button">
Delete
</a></td>
      </tr>';
        }
        exit;
    } else {
        echo '<div class="ui negative message">
  <div class="header">
    Error
  </div>
  <p>You are not authorized to access this page.
  </p></div>';
  exit;
      }
      }

      if(isset($_GET['opened'])){
        if($rank != 0){
          echo '<h1>Open tickets</h1>
          <p>Here can you see all the tickets there are need support.</p>
          <br>

          <table class="ui celled table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Category</th>
          <th>Status</th>
          <th>Created at</th>
        </tr>
      </thead>
      <tbody>';
      include('database.php');
      $abfrage = "SELECT * FROM tickets WHERE status = '0'";
      $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
      while($row = mysqli_fetch_array($ergebnis)){
        echo '<tr>
        <td>'.$row["id"].'</td>
        <td>'.$row["title"].'</td>
        <td>'.$row["category"].'</td>';

        if($row["status"] == 0){
          echo "<td>Opened</td>";
        } else if($row["status"] == 1){
          echo "<td>Closed</td>";
        } else if($row["status"] == 2){
          echo "<td>Closed by user</td>";
        }

        $time = date('Y-m-d H:i:s',$row["created_at"]);

        echo '<td>'.$time.' <a href="ticket.php?id='.$row["id"].'" class="ui primary button">
    View
  </a></td>
      </tr>';
        }
        exit;
    } else {
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

    <h1>Tickets</h1>
    <p>Here can you see your created tickets.</p>
    <br>

    <table class="ui celled table">
<thead>
  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Category</th>
    <th>Status</th>
    <th>Created at</th>
  </tr>
</thead>
<tbody>

    <?php

    include('database.php');
    $username = $_SESSION['username'];
    $abfrage = "SELECT * FROM tickets WHERE ticketauthor = '$username'";
    $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
    $data = 0;
    while($row = mysqli_fetch_array($ergebnis)){
      $data++;
      echo '<tr>
      <td>'.$row["id"].'</td>
      <td>'.$row["title"].'</td>
      <td>'.$row["category"].'</td>';

      if($row["status"] == 0){
        echo "<td>Opened</td>";
      } else if($row["status"] == 1){
        echo "<td>Closed</td>";
      } else if($row["status"] == 2){
        echo "<td>Closed by user</td>";
      }

      $time = date('Y-m-d H:i:s',$row["created_at"]);

      echo '<td>'.$time.' <a href="ticket.php?id='.$row["id"].'" class="ui primary button">
  View
</a></td>
    </tr>';
    }

    if($data == 0){
      echo '<div class="ui negative message">
<div class="header">
  Error
</div>
<p>You have not created a ticket yet.
</p></div>';
    }

    ?>

  </tbody>
</table>

      </div>
  </body>
</html>
