<?php
$INC_DIR = $_SERVER["DOCUMENT_ROOT"] . "/includes";

session_start();

//require_once "$INC_DIR/header.php";
require_once("$INC_DIR/mySqlDb.php");
require_once("$INC_DIR/functions.php");

//include("login.php");

$_POST['Username'] = clean($_POST['Username']);
$_POST['Password'] = clean($_POST['Password']);

$connection = database::MySqlConnection();

$result = $connection->query("SELECT * FROM user WHERE username='$_POST[Username]' and password='".md5($_POST['Password'])."'");

if ($result->num_rows  == 1) {
    $_SESSION['logged_in'] = true;
  while ($row = mysqli_fetch_assoc($result)) {
    $_SESSION['username'] = $row['username'];
    $_SESSION['role'] = $row['fk_role'];
  }
  header("Location: index.php");
}

else {
    header("Location: login.php?auth=fail");
}
