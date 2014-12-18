<?php
include_once "../../config.inc.php";
include_once($CONFIG["inc"]["connect"]);
include_once($CONFIG["inc"]["function"]);

$option = $_GET["option"];
$table_name = strtoupper($option);

session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"]!="true") {
  echo "Fuck You!!!!!";
  exit;
}

$m_id = $_SESSION["id"];

if ($table_name=="MEMBER") {
  $name = clean($_POST["name"]);
  $email = clean($_POST["email"]);
  if ($name!="" && $email!="" && !email($email)) {
    $sql = "update MEMBER set NAME='$name', EMAIL='$email' where ID=$m_id";
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
    $result["data"] = "Wrong Value";
  }
}
else if ($table_name=="PROFILE") {
  $check = 1;
  if (!isset($_FILES["image"])) {
    $result["status"] = "failed";
    $result["data"] = "Image Invalid";
    $check = 0;
  }

  $image = $_FILES["image"];
  $profile = getFileType($image["name"]);

  if (!in_array($profile, $CONFIG["upload"]["type"])) {
    $result["status"] = "failed";
    $result["data"] = "Dont Correct data type of image";
    $check = 0;
  }


  if ($check) {
    $sql = "update MEMBER set PROFILE='$profile' where ID=$m_id";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);

    $target_dir = $CONFIG["path"]["root"]."/".$CONFIG["image"]["member"];
    $im = $target_dir.$m_id.".".$profile;
    if (!move_uploaded_file($image["tmp_name"], $im)) {
      $e = oci_error($stid);
      $result["status"] = "failed";
      $result["data"] = "Image Error";
    } else {
      $result["status"] = "success";
      $result["data"] = "";
    }
  }
}
else if ($table_name=="PHOTO") {
  $caption = clean($_POST["caption"]);
  $p_id = intval($_POST["P_ID"]);
  $m_id = intval($m_id);

  if ($caption!="") {
    $sql = "update PHOTO set CAPTION='$caption' where ID=$p_id && OWNER=$m_id";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    if ($r) {
      $result["status"] = "success";
      $result["data"] = "";
    } else {
      $e = oci_error($stid);
      $result["status"] = "failed";
      $result["data"] = "Image Error";
    }
  } else {
    $result["status"] = "failed";
    $result["data"] = "Wrong Value";
  }
} else {
  $result["status"] = "failed";
  $result["data"] = "Wrong Option";
}

echo json_encode($result);

?>
