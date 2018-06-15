<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Show Ticket</title>
    <link rel="stylesheet" type="text/css" href="lib/semantic.min.css">
    <script
      src="https://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous"></script>
    <script src="lib/semantic.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <style media="screen">
section {
max-width: 450px;
margin: 50px auto;

div {
  max-width: 255px;
  word-wrap: break-word;
  margin-bottom: 12px;
  line-height: 24px;
  &:after {
    content: "";
    display: table;
    clear: both;
  }
}
}

.clear {clear: both}
.from-me {
position:relative;
padding:10px 20px;
color:white;
background:#0B93F6;
border-radius:25px;
float: right;

&:before {
  content:"";
  position:absolute;
  z-index:-1;
  bottom:-2px;
  right:-7px;
  height:20px;
  border-right:20px solid #0B93F6;
  border-bottom-left-radius: 16px 14px;
  -webkit-transform:translate(0, -2px);
}

&:after {
  content:"";
  position:absolute;
  z-index:1;
  bottom:-2px;
  right:-56px;
  width:26px;
  height:20px;
  background:white;
  border-bottom-left-radius: 10px;
  -webkit-transform:translate(-30px, -2px);
}
}
.from-them {
position:relative;
padding:10px 20px;
background:#E5E5EA;
border-radius:25px;
color: black;
float: left;

&:before {
  content:"";
  position:absolute;
  z-index:2;
  bottom:-2px;
  left:-7px;
  height:20px;
  border-left:20px solid #E5E5EA;
  border-bottom-right-radius: 16px 14px;
  -webkit-transform:translate(0, -2px);
}

&:after {
  content:"";
  position:absolute;
  z-index:3;
  bottom:-2px;
  left:4px;
  width:26px;
  height:20px;
  background:white;
  border-bottom-right-radius: 10px;
  -webkit-transform:translate(-30px, -2px);
}
}
      </style>
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

    <?php

    if(isset($_GET["close"])){
      if(isset($_GET["id"])){
        include('database.php');
        $id = $_GET["id"];
        $user = $_SESSION["username"];
        $abfrage = "SELECT * FROM tickets WHERE id = '$id'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        while($row = mysqli_fetch_array($ergebnis)){
          if($row["ticketauthor"] == $user){
            $abfrage2 = "UPDATE tickets SET status = '2' WHERE id = '$id'";
            $ergebnis2 = mysqli_query($mysqli,$abfrage2) or die(mysqli_error($mysqli));
            if($ergebnis2){
              echo '<div class="ui container">
                <div class="ui success message">
            <div class="header">
              Success
            </div>
            <p>The ticket with the id #'.$id.' was closed.
            </p></div></div>';
            exit;
          } else {
            echo '<div class="ui container">
              <div class="ui error message">
          <div class="header">
            Error
          </div>
          <p>You are not the owner of the ticket.
          </p></div></div>';
          }
        }
       }
      }
    }

    if(isset($_GET["rm"])){
      if(isset($_GET["id"])){
        include('database.php');
        $id = $_GET["id"];
        $user = $_SESSION["username"];
        $abfrage = "SELECT * FROM users WHERE username = '$user'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        while($row = mysqli_fetch_array($ergebnis)){
          if($row["rank"] == 2){
            $abfrage2 = "SELECT * FROM tickets WHERE id = '$id'";
            $ergebnis2 = mysqli_query($mysqli,$abfrage2) or die(mysqli_error($mysqli));
            while($row2 = mysqli_fetch_array($ergebnis2)){
              $abfrage3 = "DELETE FROM tickets WHERE id = '$id'";
              $ergebnis3 = mysqli_query($mysqli,$abfrage3) or die(mysqli_error($mysqli));
              if($ergebnis3){
                echo '<div class="ui container">
                <div class="ui success message">
          <div class="header">
            Success
          </div>
          <p>The ticket with the id #'.$id.' was deleted.
          </p></div></div>';
                exit;
              }
            }
          } else {
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>You are not authorized to access this function.
      </p></div></div>';
          }
        }
      }
    }

    if(isset($_GET["answer"])){
      if(isset($_GET["id"])){
        include('database.php');
        $id = $_GET["id"];
        $user = $_SESSION["username"];
        $answer = $_POST["answer"];
        $abfrage = "UPDATE tickets SET answer = '$answer' WHERE id = '$id'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        $abfrage2 = "UPDATE tickets SET status = '1' WHERE id = '$id'";
        $ergebnis2 = mysqli_query($mysqli,$abfrage2) or die(mysqli_error($mysqli));
        $abfrage3 = "UPDATE tickets SET answerauthor = '$user' WHERE id = '$id'";
        $ergebnis3 = mysqli_query($mysqli,$abfrage3) or die(mysqli_error($mysqli));
        $abfrage4 = "SELECT * FROM users WHERE username = '$user'";
        $ergebnis4 = mysqli_query($mysqli,$abfrage4) or die(mysqli_error($mysqli));
        while($row = mysqli_fetch_array($ergebnis4)){
          $answers = $row["answers"];
        }
        $answers++;
        $abfrage5 = "UPDATE users SET answers = '$answers' WHERE username = '$user'";
        $ergebnis5 = mysqli_query($mysqli,$abfrage5) or die(mysqli_error($mysqli));
        if($ergebnis){
          echo '<div class="ui container">
          <div class="ui success message">
    <div class="header">
      Success
    </div>
    <p>Your answer has been added to the ticket #'.$id.'.
  </p></div></div>';
        }
      }
    }

    if(isset($_GET["id"])){
      include('database.php');
      $id = $_GET["id"];
      $abfrage = "SELECT * FROM tickets WHERE id = '$id'";
      $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
      $data = 0;
          while($row = mysqli_fetch_array($ergebnis)){
            $data++;
            $user = $_SESSION["username"];
            if($row["ticketauthor"] == $user){
              $own = true;
            } else {
              $own = false;
            }
            echo '<div class="ui container">
              <h1>'.$row["title"].' | Ticket #'.$row["id"].'</h1>';
              $time = date('Y-m-d H:i:s',$row["created_at"]);
              echo '<p>This ticket was created from '.$row["ticketauthor"].' at '.$time.'.</p><br>
              <p>Status: <strong>';

              if($row["status"] == 0){
                echo "Opened";
              } else if($row["status"] == 1){
                echo "Closed";
              } else if($row["status"] == 2){
                echo "Closed by user";
              }

              echo '</strong></p>
              <p>Category: <strong>'.$row["category"].'</strong></p>
              <p>Author: <strong>'.$row["ticketauthor"].'</strong></p>';

              if($row["status"] == 0){
                if($row["ticketauthor"] == $_SESSION["username"]){
                  echo '<a href="ticket.php?close&id='.$row["id"].'" class="ui red button">
                Close ticket
                </a>';
                }
              }

              echo '<section>
            <div class="from-me">
              <p>'.$row["message"].'</p>
            </div>';
            if($row["answer"] != "null"){
              echo '<div class="clear"></div>
                <div class="from-them">
                  <p>'.$row["answer"].'</p>
                </div>
                <br><p>&nbsp;</p><i>Answer from <strong>'.$row["answerauthor"].'</strong></i>
              </section>';
            } else {
              if($row["status"] == 0){
                echo '<form class="ui form" action="ticket.php?answer&id='.$id.'" method="post">
                    <div class="field">
                      <label>Answer</label>
                      <textarea style="height: 122px;" name="answer" placeholder="Write your answer." required></textarea>
                    </div>
                    <button class="ui button" type="submit">Answer to the ticket</button>
                  </form>';
                }
              }
            }
            $user = $_SESSION["username"];
            $abfrage2 = "SELECT * FROM users WHERE username = '$user'";
            $ergebnis2 = mysqli_query($mysqli,$abfrage2) or die(mysqli_error($mysqli));
            while($row2 = mysqli_fetch_array($ergebnis2)){
              if($row2["rank"] == 0){
                if($own == false){
                  header("Location: ticket.php?permissions");
                  exit;
                }
              }
          echo '</div>';
      }
      if($data == 0){
        echo '<div class="ui container">
        <div class="ui negative message">
  <div class="header">
    Error
  </div>
  <p>The requested ticketid was not found.
</p></div></div>';
      }
    } else {
      if(isset($_GET["permissions"])){
        echo '<div class="ui container">
        <div class="ui negative message">
  <div class="header">
    Error
  </div>
  <p>You are not authorized to access this page.
  </p></div></div>';
} else {
  echo '<div class="ui container">
  <div class="ui negative message">
<div class="header">
Error
</div>
<p>No ticketid was requested.
</p></div></div>';
}
    }

     ?>

  </body>
</html>
