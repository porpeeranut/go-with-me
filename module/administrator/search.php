<?php
include_once "../../config.inc.php";
include_once($CONFIG["inc"]["connect"]);
include_once($CONFIG["inc"]["function"]);

session_start();
if ($_SESSION["admin"]!="true") {
  echo "Fuck You!!!!!";
  exit;
}


$result["status"] = "failed";
$result["data"] = "Wrong Option";

$option = $_GET["option"];
$keyword = $_GET["keyword"];
$attr = $_GET["attr"];
$s = $_GET["s"];
$n = $_GET["n"];

$table_name = strtoupper($option);
$curr_table = array("MEMBER", "PHOTO", "BADGE", "LOCATION", "TIMING", "POSTURE", "THING");
if (in_array($table_name, $curr_table)) {
  $sql = "select * from (select a.*, ROWNUM rnum from (select * from $table_name WHERE (to_char($attr) like '%$keyword%') order by id) a where rownum <= $n) where rnum >= $s";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);
  if ($r) {
    oci_fetch_all($stid, $result["data"], null, null, OCI_FETCHSTATEMENT_BY_ROW);
    $result["status"] = "success";
  } else {
    $e = oci_error($stid);
    $result["status"] = "failed";
    $result["data"] = $e["message"];
    echo json_encode($result);
  }
}
echo json_encode($result);
?>
