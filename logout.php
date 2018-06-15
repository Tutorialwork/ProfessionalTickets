
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Logout</title>
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

    <div class="ui container">
      
      <br>

      <?php

      session_start();
      if(!isset($_SESSION['username'])){
        echo '<div class="ui error message">
      <div class="header">Error</div>
      <p>You are not signed in.</p>
      </div>';
        exit;
      } else {
        session_destroy();
        header("Location: login.php");
        exit;
      }

       ?>

    </div>

  </body>
</html>
