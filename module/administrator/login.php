<?php
include_once "../../config.inc.php";

$user = $_POST["user"];
$pass = $_POST["pass"];

if ($user==$CONFIG["admin"]["username"] && $pass==$CONFIG["admin"]["password"]) {
  $result["status"] = "success";
  $result["data"] = "";
  session_start();
  $_SESSION["admin"] = "true";
} else {
  $result["status"] = "failed";
  $result["data"] = "Wrong Username or Password";
}
echo json_encode($result);
?>
