<?php
include_once "../../config.inc.php";
include_once($CONFIG["inc"]["connect"]);
include_once($CONFIG["inc"]["function"]);

session_start();
if ($_SESSION["login"]!="true") {
  echo "Fuck You!!!!!";
  exit;
}
$m_id = $_SESSION["id"];


$result["status"] = "failed";
$result["data"] = "Wrong Option";

$option = $_GET["option"];

if (!isset($_GET["start"])) $start = 0;
else $start = $_GET["start"];

if (!isset($_GET["end"])) $end = 99999999999;
else $end = $_GET["end"];

$table_name = strtoupper($option);
$curr_table = array("BADGE", "LOCATION", "TIMING", "POSTURE", "THING");
if (in_array($table_name, $curr_table)) {
  $sql = "select * from (select a.*, ROWNUM rnum from (select * from $table_name order by id) a where rownum <= $end) where rnum >= $start";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);
  if ($r) {
    oci_fetch_all($stid, $result["data"], null, null, OCI_FETCHSTATEMENT_BY_ROW);
    $result["status"] = "success";
  } else {
    $e = oci_error($stid);
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
}
else if ($table_name=="PHOTO") {
  $sql = "select * from (select a.*, ROWNUM rnum from (select * from $table_name order by id) a where rownum <= $end) where rnum >= $start";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);
  if ($r) {
    $result["status"] = "success";
    oci_fetch_all($stid, $result["data"], null, null, OCI_FETCHSTATEMENT_BY_ROW);
    print_r($result["data"]);
    $n = count($result["data"]);
    for ($i=0;$i<$n;$i++) {
      $id = $result["data"][$i]["ID"];
      $sql = "select M_ID,MSG,DATE_TIME from COMMENT_PHOTO where P_ID=$id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["comment"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select M_ID from LIKE_PHOTO where P_ID=$id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["like"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select M_ID from TAG where P_ID=$id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["tag"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select THING_ID from PHOTO_WITH where PHOTO_ID=$id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["with"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $result["status"] = "success";
      $result["data"] = "";
    }
  } else {
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
}
else if($table_name=="MEMBER") {
  if (!isset($_GET["id"])) $id = $m_id;
  else $id = $_GET["id"];

  $sql = "select * from MEMBER where ID=$id";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);

  if ($r) {
    oci_fetch_all($stid, $result["data"], null, null, OCI_FETCHSTATEMENT_BY_ROW);
    $result["status"] = "success";

    $sql = "select * from MESSAGE where M_ID1=$id or M_ID2=$id";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    oci_fetch_all($stid, $result["data"]["message"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

    $sql = "select BADGE_ID from BADGE_COLLECT where MEMBER_ID=$id";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    oci_fetch_all($stid, $result["data"]["badge"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

    $sql = "select * from PHOTO where OWNER_ID=$id";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    oci_fetch_all($stid, $result["data"]["phogo"], null, null, OCI_FETCHSTATEMENT_BY_ROW);
  } else {
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
}
echo json_encode($result);
?>
