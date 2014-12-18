<?php
include_once "../../config.inc.php";
include_once($CONFIG["inc"]["connect"]);
include_once($CONFIG["inc"]["function"]);

session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"]!="true") {
  echo "Fuck You!!!!!";
  exit;
}
$m_id = $_SESSION["id"];


$result["status"] = "failed";
$result["data"] = "Wrong Option";

$option = $_GET["option"];

$table_name = strtoupper($option);
$curr_table = array("LOCATION", "TIMING", "POSTURE", "THING");
if (in_array($table_name, $curr_table)) {
  $keyword = intval($_GET["keyword"]);
  $sql = "select * from $table_name where ID=$keyword";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);
  if ($r) {
    oci_fetch_all($stid, $result["data"], null, null, OCI_FETCHSTATEMENT_BY_ROW);
    $result["data"] = $result["data"][0];

    $result["status"] = "success";
  } else {
    $e = oci_error($stid);
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
}
else if ($table_name=="MEMBER") {
  $keyword = clean($_GET["keyword"]);
  $sql = "select * from MEMBER where NAME like '%".$keyword."%' and USERNAME like '%".$keyword."%' and ROWNUM<=5";
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
else if ($table_name=="BADGE") {
  $keyword = intval($_GET["keyword"]);
  $sql = "select * from BADGE where ID=$keyword";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);
  if ($r) {
    $result["status"] = "success";
    oci_fetch_all($stid, $result["data"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

    $result["data"] = $result["data"]["0"];

    $id = $result["data"]["ID"];

    $sql = "select b.ID, b.NAME, b.detail from BADGE_THING a, THING b where a.BADGE_ID=$id and b.ID=a.THING_ID";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    oci_fetch_all($stid, $result["data"]["thing"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

    $sql = "select b.ID, b.USERNAME from BADGE_MEMBER a, MEMBER b where a.BADGE_ID=$id and b.ID=a.MEMBER_ID";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    oci_fetch_all($stid, $result["data"]["member"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

    $sql = "select b.ID, b.NAME, b.detail from BADGE_TIMING a, TIMING b where a.BADGE_ID=$id and b.ID=a.TIMING_ID";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    oci_fetch_all($stid, $result["data"]["timing"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

    $sql = "select b.ID, b.NAME, b.detail from BADGE_POSTURE a, POSTURE b where a.BADGE_ID=$id and b.ID=a.POSTURE_ID";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    oci_fetch_all($stid, $result["data"]["posture"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

    $sql = "select b.ID, b.NAME, b.detail from BADGE_LOCATION a, LOCATION b where a.BADGE_ID=$id and b.ID=a.LOCATION_ID";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    oci_fetch_all($stid, $result["data"]["location"], null, null, OCI_FETCHSTATEMENT_BY_ROW);
  } else {
    $e = oci_error($stid);
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
}
echo json_encode($result);

?>
