<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="lib/semantic.min.css">
    <script
      src="https://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous"></script>
    <script src="lib/semantic.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/components/icon.min.css'>
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body>

    <!-- ProfessionalTickets by Tutorialwork -->

    <?php

      session_start();
	    if(isset($_SESSION['username'])){
        echo '<div class="ui container"><div class="ui negative message">
  <div class="header">
    Error
  </div>
  <p>You are already signed in.
  </p></div></div>';
        exit;
	    }

    include('database.php');
    $abfrage = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY UNIQUE,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rank` int(6) NOT NULL,
  `ban` int(6) NOT NULL,
  `answers` int(6) NOT NULL,
  `status` int(6) NOT NULL,
  `reg_at` varchar(255)
);";
    $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));

     ?>

    <div class="ui huge menu">
      <a class="item active" href="login.php">
        Login
      </a>
    </div>

    <div class="ui container">

    <h1>Login</h1>
    <p>Here can you login into your account or create a new account if you don't have one.</p>

    <?php

    if(isset($_GET["register"])){
      include('database.php');
      include('recaptcha-settings.php');
      if($enabled == false){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pw1 = $_POST['password'];
        $pw2 = $_POST['rpassword'];
        if(strpos($username, "'") !== false) {
          echo '<div class="ui container">
          <div class="ui negative message">
    <div class="header">
      Error
    </div>
    <p>You can not use this character.
    </p></div></div>';
            exit;
          }

          if(strpos($email, "'") !== false) {
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>You can not use this character.
      </p></div></div>';
            exit;
          }

          if(strpos($pw2, "'") !== false) {
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>You can not use this character.
      </p></div></div>';
            exit;
          }

          if(strpos($pw1, "'") !== false) {
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>You can not use this character.
      </p></div></div>';
            exit;
          }
        $abfrage2 = "SELECT * FROM users WHERE username = '$username'";
        $ergebnis2 = mysqli_query($mysqli,$abfrage2) or die(mysqli_error($mysqli));
        $data = 0;
        while($row = mysqli_fetch_array($ergebnis2)){
          $data++;
        }
        $abfrage3 = "SELECT * FROM users WHERE email = '$email'";
        $ergebnis3 = mysqli_query($mysqli,$abfrage3) or die(mysqli_error($mysqli));
        $data2 = 0;
        while($row2 = mysqli_fetch_array($ergebnis3)){
          $data2++;
        }
        if($data2 != 0){
          echo '<div class="ui negative message">
    <div class="header">
      Error
    </div>
    <p>This email is already in use.
    </p></div>';
          echo '<div class="ui grid">
            <div class="two column large screen only row">
              <div class="column">
                <div class="ui segment">
                  <form class="ui form" action="login.php?login" method="post">
                    <h1><i class="user alternate icon"></i>Login</h1>
                    <div class="field">
                      <label>Username</label>
                      <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="field">
                      <label>Password</label>
                      <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button class="ui button" type="submit">Login</button>
                  </form>
                </div>
              </div>
              <div class="column">
                <div class="ui segment">
                  <form class="ui form" action="login.php?register" method="post">
                    <h1><i class="add user alternate icon"></i>Create a new account</h1>
                    <div class="field">
                      <label>Username</label>
                      <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="field">
                      <label>Email</label>
                      <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="field">
                      <label>Password</label>
                      <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="field">
                      <label>Repeat password</label>
                      <input type="password" name="rpassword" placeholder="Repeat password" required>
                    </div>
                    <button class="ui button" type="submit">Create account</button>
                  </form>
                </div>
              </div>
            </div>

          </div>';
          exit;
        }
        if($data == 0){
          $pw1 = $_POST['password'];
          $pw2 = $_POST['rpassword'];
          $code = rand(100000, 999999);
          $pwhash = password_hash($pw1, PASSWORD_BCRYPT);
          $time = time();
          if($pw1 == $pw2){
            $abfrage = "INSERT INTO users (username, email, password, rank, ban, answers, status, reg_at) VALUES
            ('$username', '$email', '$pwhash', '0', '0', '0', '$code', '$time')";
            $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
            if($ergebnis){
              $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?activate&key=$code&acc=$username";
              $finishurl = str_replace("?register","",$url);
              $subject = 'Activate your account';
              $message = 'Hello '.$username.'<br><br>For this mail someone has requested the registration of an account. To create it, click on the link below.
              <br><br>
              Link: '.$finishurl;
              $headers = 'Content-type: text/html; charset=utf-8;
              From: developer@tutorialwork.de' . "\r\n" .
              'Reply-To: noreply@tutorialwork.de' . "\r\n" .
              'X-Mailer: PHP/' . phpversion();
              mail($email, $subject, $message, $headers);
              echo '<div class="ui container">
              <div class="ui success message">
        <div class="header">
          Account created
        </div>
        <p>Your account has been created as soon as you confirm it by clicking on the link in the email it is activated.
        </p></div></div>';
            } else {
              echo '<div class="ui container">
              <div class="ui negative message">
        <div class="header">
          Error
        </div>
        <p>An unknown error has occurred.
        </p></div></div>';
            }
          } else {
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>The passwords do not match.
      </p></div></div>';
          }
        } else {
          echo '<div class="ui container">
          <div class="ui negative message">
    <div class="header">
      Error
    </div>
    <p>This name is already taken.
    </p></div></div>';
        }
      }
      if($enabled == true){
        if($_POST["g-recaptcha-response"]){
          $username = $_POST['username'];
          $email = $_POST['email'];
          $pw1 = $_POST['password'];
          $pw2 = $_POST['rpassword'];
          if(strpos($username, "'") !== false) {
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>You can not use this character.
      </p></div></div>';
              exit;
            }

            if(strpos($email, "'") !== false) {
              echo '<div class="ui container">
              <div class="ui negative message">
        <div class="header">
          Error
        </div>
        <p>You can not use this character.
        </p></div></div>';
              exit;
            }

            if(strpos($pw2, "'") !== false) {
              echo '<div class="ui container">
              <div class="ui negative message">
        <div class="header">
          Error
        </div>
        <p>You can not use this character.
        </p></div></div>';
              exit;
            }

            if(strpos($pw1, "'") !== false) {
              echo '<div class="ui container">
              <div class="ui negative message">
        <div class="header">
          Error
        </div>
        <p>You can not use this character.
        </p></div></div>';
              exit;
            }
          $abfrage2 = "SELECT * FROM users WHERE username = '$username'";
          $ergebnis2 = mysqli_query($mysqli,$abfrage2) or die(mysqli_error($mysqli));
          $data = 0;
          while($row = mysqli_fetch_array($ergebnis2)){
            $data++;
          }
          $abfrage3 = "SELECT * FROM users WHERE email = '$email'";
          $ergebnis3 = mysqli_query($mysqli,$abfrage3) or die(mysqli_error($mysqli));
          $data2 = 0;
          while($row2 = mysqli_fetch_array($ergebnis3)){
            $data2++;
          }
          if($data2 != 0){
            echo '<div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>This email is already in use.
      </p></div>';
            echo '<div class="ui grid">
              <div class="two column large screen only row">
                <div class="column">
                  <div class="ui segment">
                    <form class="ui form" action="login.php?login" method="post">
                      <h1><i class="user alternate icon"></i>Login</h1>
                      <div class="field">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Username" required>
                      </div>
                      <div class="field">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Password" required>
                      </div>
                      <button class="ui button" type="submit">Login</button>
                    </form>
                  </div>
                </div>
                <div class="column">
                  <div class="ui segment">
                    <form class="ui form" action="login.php?register" method="post">
                      <h1><i class="add user alternate icon"></i>Create a new account</h1>
                      <div class="field">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Username" required>
                      </div>
                      <div class="field">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email" required>
                      </div>
                      <div class="field">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Password" required>
                      </div>
                      <div class="field">
                        <label>Repeat password</label>
                        <input type="password" name="rpassword" placeholder="Repeat password" required>
                      </div>
                      <button class="ui button" type="submit">Create account</button>
                    </form>
                  </div>
                </div>
              </div>

            </div>';
            exit;
          }
          if($data == 0){
            $pw1 = $_POST['password'];
            $pw2 = $_POST['rpassword'];
            $code = rand(100000, 999999);
            $pwhash = password_hash($pw1, PASSWORD_BCRYPT);
            $time = time();
            if($pw1 == $pw2){
              $abfrage = "INSERT INTO users (username, email, password, rank, ban, answers, status, reg_at) VALUES
              ('$username', '$email', '$pwhash', '0', '0', '0', '$code', '$time')";
              $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
              if($ergebnis){
                $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]?activate&key=$code&acc=$username";
                $finishurl = str_replace("?register","",$url);
                $subject = 'Activate your account';
                $message = 'Hello '.$username.'<br><br>For this mail someone has requested the registration of an account. To create it, click on the link below.
                <br><br>
                Link: '.$finishurl;
                $headers = 'Content-type: text/html; charset=utf-8;
                From: developer@tutorialwork.de' . "\r\n" .
                'Reply-To: noreply@tutorialwork.de' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
                mail($email, $subject, $message, $headers);
                echo '<div class="ui container">
                <div class="ui success message">
          <div class="header">
            Account created
          </div>
          <p>Your account has been created as soon as you confirm it by clicking on the link in the email it is activated.
          </p></div></div>';
              } else {
                echo '<div class="ui container">
                <div class="ui negative message">
          <div class="header">
            Error
          </div>
          <p>An unknown error has occurred.
          </p></div></div>';
              }
            } else {
              echo '<div class="ui container">
              <div class="ui negative message">
        <div class="header">
          Error
        </div>
        <p>The passwords do not match.
        </p></div></div>';
            }
          } else {
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>This name is already taken.
      </p></div></div>';
          }
        } else {
          echo '<div class="ui container">
          <div class="ui negative message">
    <div class="header">
      Error
    </div>
    <p>You have to fill in the captcha.
    </p></div></div>';
        }
      }
    }

    if(isset($_GET["login"])){
      include('database.php');
      include('recaptcha-settings.php');
      if($enabled == false){
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(strpos($username, "'") !== false) {
          echo '<div class="ui container">
          <div class="ui negative message">
    <div class="header">
      Error
    </div>
    <p>You can not use this character.
    </p></div></div>';
            exit;
          }

          if(strpos($password, "'") !== false) {
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>You can not use this character.
      </p></div></div>';
            exit;
          }
        $abfrage = "SELECT * FROM users WHERE username = '$username'";
        $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
        $data = 0;
        while($row = mysqli_fetch_array($ergebnis)){
          $data++;
          if(password_verify($password, $row["password"])){
            if($row["ban"] == 0){
              if($row["status"] != 0){
                echo '<div class="ui container">
                <div class="ui negative message">
          <div class="header">
            Error
          </div>
          <p>Your account has not been activated yet.
          </p></div></div>';
              } else {
                session_start();
                $_SESSION['username'] = $username;
                header('Location: index.php');
              }
            } else {
              echo '<div class="ui container">
              <div class="ui negative message">
        <div class="header">
          Error
        </div>
        <p>Your account is banned.
        </p></div></div>';
            }
          } else {
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>The password is wrong.
      </p></div></div>';
          }
        }
        if($data == 0){
          echo '<div class="ui container">
          <div class="ui negative message">
    <div class="header">
      Error
    </div>
    <p>This account is not registered.
    </p></div></div>';
        }
      }
      if($enabled == true){
        if($_POST["g-recaptcha-response"]){
          $username = $_POST['username'];
          $password = $_POST['password'];
          if(strpos($username, "'") !== false) {
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>You can not use this character.
      </p></div></div>';
              exit;
            }

            if(strpos($password, "'") !== false) {
              echo '<div class="ui container">
              <div class="ui negative message">
        <div class="header">
          Error
        </div>
        <p>You can not use this character.
        </p></div></div>';
              exit;
            }
          $abfrage = "SELECT * FROM users WHERE username = '$username'";
          $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
          $data = 0;
          while($row = mysqli_fetch_array($ergebnis)){
            $data++;
            if(password_verify($password, $row["password"])){
              if($row["ban"] == 0){
                if($row["status"] != 0){
                  echo '<div class="ui container">
                  <div class="ui negative message">
            <div class="header">
              Error
            </div>
            <p>Your account has not been activated yet.
            </p></div></div>';
                } else {
                  session_start();
                  $_SESSION['username'] = $username;
                  header('Location: index.php');
                }
              } else {
                echo '<div class="ui container">
                <div class="ui negative message">
          <div class="header">
            Error
          </div>
          <p>Your account is banned.
          </p></div></div>';
              }
            } else {
              echo '<div class="ui container">
              <div class="ui negative message">
        <div class="header">
          Error
        </div>
        <p>The password is wrong.
        </p></div></div>';
            }
          }
          if($data == 0){
            echo '<div class="ui container">
            <div class="ui negative message">
      <div class="header">
        Error
      </div>
      <p>This account is not registered.
      </p></div></div>';
          }
        } else {
           echo '<div class="ui container">
           <div class="ui negative message">
     <div class="header">
       Error
     </div>
     <p>You have to fill in the captcha.
     </p></div></div>';
        }
      }
    }

    if(isset($_GET["activate"])){
      if(isset($_GET["key"])){
        if(isset($_GET["acc"])){
          $key = $_GET["key"];
          $acc = $_GET["acc"];
          $abfrage = "SELECT status FROM users WHERE username = '$acc'";
          $ergebnis = mysqli_query($mysqli,$abfrage) or die(mysqli_error($mysqli));
          while($row = mysqli_fetch_array($ergebnis)){
            if($row["status"] == $key){
              $abfrage2 = "UPDATE users SET status = '0' WHERE username = '$acc'";
              $ergebnis2 = mysqli_query($mysqli,$abfrage2) or die(mysqli_error($mysqli));
              echo '<div class="ui container">
              <div class="ui success message">
        <div class="header">
          Success
        </div>
        <p>Your account has been activated and you can log in now.
        </p></div></div>';
            } else {
              echo '<div class="ui container">
              <div class="ui negative message">
        <div class="header">
          Error
        </div>
        <p>The activation was unsuccessful.
        </p></div></div>';
            }
          }
        }
      }
    }

     ?>

     <br>

     <h1><i class="user alternate icon"></i>Login</h1>
     <form class="ui form" action="mobile-login.php?login" method="post">
       <div class="field">
         <label>Username</label>
         <input type="text" name="username" placeholder="Username" required>
       </div>
       <div class="field">
         <label>Password</label>
         <input type="password" name="password" placeholder="Password" required>
       </div>
       <?php
       include('recaptcha-settings.php');
       if($enabled == true){
         echo '<div class="g-recaptcha" data-sitekey="'.$sitekey.'"></div><br>';
       }
        ?>
       <button class="ui button" type="submit">Login</button>
</form>

<h1><i class="add user alternate icon"></i>Register</h1>
<form class="ui form" action="mobile-login.php?register" method="post">
  <div class="field">
    <label>Username</label>
    <input type="text" name="username" placeholder="Username" required>
  </div>
  <div class="field">
    <label>Email</label>
    <input type="email" name="email" placeholder="Email" required>
  </div>
  <div class="field">
    <label>Password</label>
    <input type="password" name="password" placeholder="Password" required>
  </div>
  <div class="field">
    <label>Repeat password</label>
    <input type="password" name="rpassword" placeholder="Repeat password" required>
  </div>
  <?php
  include('recaptcha-settings.php');
  if($enabled == true){
    echo '<div class="g-recaptcha" data-sitekey="'.$sitekey.'"></div><br>';
  }
   ?>
  <button class="ui button" type="submit">Create account</button>
</form>

  </body>
</html>
