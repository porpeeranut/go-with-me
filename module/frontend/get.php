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

if (!isset($_GET["start"])) $start = 0;
else $start = $_GET["start"];

if (!isset($_GET["end"])) $end = 99999999999;
else $end = $_GET["end"];

$table_name = strtoupper($option);
$curr_table = array("LOCATION", "TIMING", "POSTURE", "THING");
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

    $n = count($result["data"]);
    for ($i=0;$i<$n;$i++) {
      $id = $result["data"]["$i"]["ID"];
      $owner = $result["data"]["$i"]["OWNER_ID"];
      $loc_id = $result["data"]["$i"]["LOC_ID"];
      $timing_id = $result["data"]["$i"]["LOC_ID"];
      $pos_id = $result["data"]["$i"]["LOC_ID"];
      $thing_id = $result["data"]["$i"]["LOC_ID"];

      $sql = "select ID, NAME from LOCATION where ID=$loc_id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["location"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select ID, NAME from TIMING where ID=$timing_id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["timing"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select ID, NAME from POSTURE where ID=$pos_id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["posture"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select ID, NAME from THING where ID=$thing_id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["thing"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select * from MEMBER where ID=$owner";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["owner"], null, null, OCI_FETCHSTATEMENT_BY_ROW);
      $sql = "select b.ID M_ID, b.USERNAME, a.ID C_ID, a.MSG, a.DATE_TIME from COMMENT_PHOTO a, MEMBER b where a.P_ID=$id and a.M_ID=b.ID";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["comment"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select b.ID, b.USERNAME from LIKE_PHOTO a, MEMBER b where a.P_ID=$id and a.M_ID=b.ID";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["like"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select b.ID, b.USERNAME from TAG a, MEMBER b where a.P_ID=$id and a.M_ID=b.ID";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["tag"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $result["status"] = "success";
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
    oci_fetch_all($stid, $result["data"]["photo"], null, null, OCI_FETCHSTATEMENT_BY_ROW);
  } else {
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
}
else if($table_name=="BADGE") {
  $sql = "select * from BADGE";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);
  if ($r) {
    $result["status"] = "success";
    oci_fetch_all($stid, $result["data"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

    $n = count($result["data"]);
    for ($i=0;$i<$n;$i++) {
      $id = $result["data"]["$i"]["ID"];
      $sql = "select b.ID, b.NAME, b.detail from BADGE_THING a, THING b where a.BADGE_ID=$id and b.ID=a.THING_ID";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["thing"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select b.ID, b.USERNAME from BADGE_MEMBER a, MEMBER b where a.BADGE_ID=$id and b.ID=a.MEMBER_ID";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["member"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select b.ID, b.NAME, b.detail from BADGE_TIMING a, TIMING b where a.BADGE_ID=$id and b.ID=a.TIMING_ID";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["timing"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select b.ID, b.NAME, b.detail from BADGE_POSTURE a, POSTURE b where a.BADGE_ID=$id and b.ID=a.POSTURE_ID";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["posture"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $sql = "select b.ID, b.NAME, b.detail from BADGE_LOCATION a, LOCATION b where a.BADGE_ID=$id and b.ID=a.LOCATION_ID";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      oci_fetch_all($stid, $result["data"][$i]["location"], null, null, OCI_FETCHSTATEMENT_BY_ROW);

      $result["status"] = "success";
    }
  } else {
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
}
else if($table_name=="TOPUSER") {
  $sql = "select * from MEMBER where rownum<=10 order by ALL_SCORE DESC";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);
  if ($r) {
    $result["status"] = "success";
    oci_fetch_all($stid, $result["data"], null, null, OCI_FETCHSTATEMENT_BY_ROW);
  } else {
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
}
echo json_encode($result);
?>
