<?php
include_once "../../config.inc.php";
include_once($CONFIG["inc"]["connect"]);
include_once($CONFIG["inc"]["function"]);

$result["status"] = "failed";
$result["data"] = "Wrong Option";

$option = $_GET["option"];
$id = $_GET["id"];

$COLUMN["BADGE_COLLECT"] = "MEMBER_ID";
$COLUMN["BADGE_LOCATION"] = "BADGE_ID";
$COLUMN["BADGE_MEMBER"] = "BADGE_ID";
$COLUMN["BADGE_THING"] = "BADGE_ID";
$COLUMN["BADGE_TIMING"] = "BADGE_ID";
$COLUMN["COMMENT_PHOTO"] = "P_ID";
$COLUMN["LIKE_PHOTO"] = "P_ID";
$COLUMN["PHOTO_WITH"] = "PHOTO_ID";
$COLUMN["TAG"] = "P_ID";
$COLUMN["PHOTO"] = "OWNER_ID";

$TABLE["BADGE_COLLECT"] = "BADGE";
$TABLE["BADGE_LOCATION"] = "LOCATION";
$TABLE["BADGE_MEMBER"] = "MEMBER";
$TABLE["BADGE_THING"] = "THING";
$TABLE["BADGE_TIMING"] = "TIMING";
$TABLE["COMMENT_PHOTO"] = "MEMBER";
$TABLE["LIKE_PHOTO"] = "MEMBER";
$TABLE["PHOTO_WITH"] = "MEMBER";
$TABLE["TAG"] = "MEMBER";
$TABLE["PHOTO"] = "MEMBER";

$COLUMN2["BADGE_COLLECT"] = "BADGE_ID";
$COLUMN2["BADGE_LOCATION"] = "LOCATION_ID";
$COLUMN2["BADGE_MEMBER"] = "MEMBER_ID";
$COLUMN2["BADGE_THING"] = "THING_ID";
$COLUMN2["BADGE_TIMING"] = "TIMING_ID";
$COLUMN2["COMMENT_PHOTO"] = "M_ID";
$COLUMN2["LIKE_PHOTO"] = "M_ID";
$COLUMN2["PHOTO_WITH"] = "THING_ID";
$COLUMN2["TAG"] = "M_ID";
$COLUMN2["PHOTO"] = "OWNER_ID";

$table_name = strtoupper($option);
$curr_table = array("BADGE_COLLECT", "BADGE_LOCATION", "BADGE_MEMBER", "BADGE_THING", "BADGE_TIMING", "COMMENT_PHOTO", "LIKE_PHOTO", "PHOTO_WITH", "TAG", "PHOTO");
if (in_array($table_name, $curr_table)) {
  $col = $COLUMN[$table_name];
  $tal = $TABLE[$table_name];
  $col2 = $COLUMN2[$table_name];
  $sql = "select * from $table_name a, $tal b where a.$col=$id and a.$col2=b.id";
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
echo json_encode($result);
?>
