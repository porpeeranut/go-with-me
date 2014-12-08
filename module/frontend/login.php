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

$n = oci_fetch_all($stid, $row, null, null, OCI_FETCHSTATEMENT_BY_ROW);

if ($r && $n==1) {
  $result["status"] = "success";
  $result["data"] = "";
  
  session_start();
  $_SESSION["login"] = "true";
  $_SESSION["id"] = $row[0]["ID"];
}

echo json_encode($result);
?>