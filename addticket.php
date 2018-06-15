<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Create ticket</title>
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
      <a class="item active" href="addticket.php">
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

      if(isset($_GET["create"])){
        include('database.php');
        $titel = $_POST['title'];
        $message = $_POST['message'];
        $category = $_POST['category'];
        $time = time();
        $user = $_SESSION['username'];
        $abfrage = "INSERT INTO tickets (title, category, message, answer, status, ticketauthor, answerauthor, created_at) VALUES
        ('$titel', '$category', '$message', 'null', '0', '$user', 'null', '$time')";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        if($ergebnis){
          echo '<div class="ui container">
          <div class="ui success message">
    <div class="header">
      Success
    </div>
    <p>Your ticket was created. You can see al your tickets <a href="tickets.php">here</a>.
  </p></div></div>';
          exit;
        }
      }

       ?>

    <h1>Create ticket</h1>
    <p>On this page you can write a ticket. To create a ticket fill out the fields.</p>

    <form class="ui form" action="addticket.php?create" method="post">
      <div class="field">
        <label>Title</label>
        <input type="text" name="title" placeholder="Title" required>
      </div>
      <div class="field">
        <label>Category</label>
        <select class="ui search dropdown" name="category">
          <option>Report</option>
          <option>Question</option>
          <option>Problem</option>
          <option>Bugreport</option>
          <option>Other</option>
        </select>
      </div>
      <div class="field">
        <label>Message</label>
        <textarea style="height: 122px;" name="message" placeholder="Write your message in this field." required></textarea>
      </div>
      <i>When you need to upload file please use a serious provider for files.</i>
      <br>
      <button class="ui button" type="submit">Create a new Ticket</button>
    </form>

      </div>
  </body>
</html>
