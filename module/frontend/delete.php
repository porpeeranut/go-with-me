<?php

session_start();
if ($_SESSION["login"]!="true" ) {
  echo "Fuck You!!!!!";
  exit;
}

$m_id = $_SESSION["id"];

$option = $_GET["option"];
$table_name = strtoupper($option);
if ($table_name=="LIKE") {
  $p_id = intval($_GET["p_id"]);
  $sql = "delete from LIKE_PHOTO where M_ID=$m_id and P_ID=$p_id";
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
}
else if ($table_name=="COMMENT") {
  $id = intval($_GET["id"]);
  $sql = "delete from COMMENT_PHOTO where ID=$id";
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
}
else if ($table_name=="PHOTO") {
  $id = intval($_GET["id"]);
  $sql = "delete from COMMENT_PHOTO where ID=$id and OWNER_ID=$m_id";
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
}
?>
