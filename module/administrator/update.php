<?php
include_once "../../config.inc.php";
include_once "../connect.php";

session_start();
if ($_SESSION["admin"]!="true") {
  echo "Fuck You!!!!!";
  exit;
}

$option = $_GET["option"];
$id = $_GET["id"];

if ($option=="badge") {
  $name = $_POST["name"];
  $score = intval($_POST["score"]);
  $detail = $_POST["detail"];

  $sql = "update BADGE set name='$name', score=$score, detail='$detail' where id=$id";
}
else if($option=="member") {
  $name = $_POST["name"];
  $all_score = intval($_POST["all_score"]);
  $email = $_POST["email"];
  $sql = "update MEMBER set name='$name', all_score='$all_score', email='$email' where id=$id";
}
else if($option=="photo") {
  $caption = $_POST["caption"];
  $sql = "update PHOTO set caption='$caption' where id=$id";
} else {
  $table_name = strtoupper($option);
  $curr_table = array("LOCATION", "TIMING", "POSTURE", "THING");
  if (in_array($table_name, $curr_table)) {
    $name = $_POST["name"];
    $detail = $_POST["detail"];
    $sql = "update $table_name set name='$name', detail='$detail' where id=$id";
  } else {
    $result["status"] = "failed";
    $result["data"] = "Wrong Option";
    echo json_encode($result);
    exit;
  }
}

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

echo json_encode($result);
?>
