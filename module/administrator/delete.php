<?php
include_once "../../config.inc.php";
include_once($CONFIG["inc"]["connect"]);
include_once($CONFIG["inc"]["function"]);

$option = $_GET["option"];
$id = $_GET["id"];

$table_name = strtoupper($option);
$curr_table = array("MEMBER", "PHOTO", "LOCATION", "TIMING", "POSTURE", "THING", "BADGE");

if (in_array($table_name, $curr_table)) {
  $sql = "delete from $table_name where id=$id";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);
  if ($r) {
    $result["status"] = "success";
    $result["data"] = "";
  } else {
    $e = oci_error($stid);
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
} else {
  $result["status"] = "failed";
  $result["data"] = "Wrong Option";
}

echo json_encode($result);
?>
