<?php
include_once "../../config.inc.php";
include_once($CONFIG["inc"]["connect"]);
include_once($CONFIG["inc"]["function"]);

$user = clean($_POST["user"]);
$pass = md5($_POST["pass"]);

$sql = "select id from member where username='$user' and password='$pass'";
$stid = oci_parse($db_conn, $sql);
$r = oci_execute($stid);

$result["status"] = "failed";
$result["data"] = "Username or Password Failed";

if ($r) {
  $result["status"] = "success"
  $result["data"] = "";
  $row = oci_fetch_array($stid, OCI_ASSOC);
  session_start();
  $_SESSION["login"] = "true";
  $_SESSION["id"] = $row["id"];
}

echo json_encode($result);
?>
