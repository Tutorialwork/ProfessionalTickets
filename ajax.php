<?php
require("datamanager.php");
if(isset($_GET["del"]) && isset($_POST["name"])){
  //Delete an account by name
  deleteAccount($_POST["name"]);
} else {
  echo "Invalid request.";
}
 ?>
