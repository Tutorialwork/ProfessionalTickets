<?php
function getSetting($setting){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM settings WHERE NAME = :setting");
  $stmt->bindParam(":setting", $setting, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["VALUE"];
}
function setSetting($setting, $value){
  require("mysql.php");
  $stmt = $mysql->prepare("UPDATE settings SET VALUE = :value WHERE NAME = :setting");
  $stmt->bindParam(":setting", $setting, PDO::PARAM_STR);
  $stmt->bindParam(":value", $value, PDO::PARAM_STR);
  $stmt->execute();
}
function getAccountID($username){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
  $stmt->bindParam(":user", $username, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["ID"];
}
function getAccountName($id){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM accounts WHERE ID = :id");
  $stmt->bindParam(":id", $id, PDO::PARAM_INT);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["USERNAME"];
}
function getAccountRank($username){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :user");
  $stmt->bindParam(":user", $username, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["ACCOUNTRANK"];
}
function getCategory($id){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM categorys WHERE ID = :id");
  $stmt->bindParam(":id", $id, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["NAME"];
}
function getTicketTitle($id){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM tickets WHERE ID = :id");
  $stmt->bindParam(":id", $id, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["TITLE"];
}
function getTicketContent($id){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM tickets WHERE ID = :id");
  $stmt->bindParam(":id", $id, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["MESSAGE"];
}
function getTicketDate($id){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM tickets WHERE ID = :id");
  $stmt->bindParam(":id", $id, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["CREATIONDATE"];
}
function getTicketCreatorID($id){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM tickets WHERE ID = :id");
  $stmt->bindParam(":id", $id, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["CREATOR"];
}
function displayTimestamp($time){
  if(getSetting("lang") == "en"){
    return date("m/d/Y h:i A", $time);
  } else if(getSetting("lang") == "de"){
    return date("d.m.Y H:i", $time);
  }
}
function isTicketClosed($id){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM tickets WHERE ID = :id");
  $stmt->bindParam(":id", $id, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  if($row["STATUS"] == 0){
    return false;
  } else {
    return true;
  }
}
function deleteAccount($username){
  require("mysql.php");
  $stmt = $mysql->prepare("DELETE FROM accounts WHERE USERNAME = :name");
  $stmt->bindParam(":name", $username, PDO::PARAM_STR);
  $stmt->execute();
}
function getAccountEmail($username){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :name");
  $stmt->bindParam(":name", $username, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["EMAIL"];
}
function getFirstLoginDate($username){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :name");
  $stmt->bindParam(":name", $username, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["FIRSTLOGIN"];
}
function getLastLoginDate($username){
  require("mysql.php");
  $stmt = $mysql->prepare("SELECT * FROM accounts WHERE USERNAME = :name");
  $stmt->bindParam(":name", $username, PDO::PARAM_STR);
  $stmt->execute();
  $row = $stmt->fetch();
  return $row["LASTLOGIN"];
}
function updateLogin($username){
  require("mysql.php");
  $stmt = $mysql->prepare("UPDATE accounts SET LASTLOGIN = :value WHERE USERNAME = :user");
  $stmt->bindParam(":user", $username, PDO::PARAM_STR);
  $now = time();
  $stmt->bindParam(":value", $now, PDO::PARAM_STR);
  $stmt->execute();
}
 ?>
