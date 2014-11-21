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
$result["data"] = "";

$option = $_GET["option"];

if ($option=="badge") {

  $name = $_POST["name"];
  $score = intval($_POST["score"]);
  $detail = $_POST["detail"];
  $is_tim = intval($_POST["is_tim"]);
  $tim_id = $_POST["tim_id"];
  $is_pos = intval($_POST["is_pos"]);
  $pos_id = $_POST["pos_id"];
  $is_loc = intval($_POST["is_loc"]);
  $loc_id = $_POST["loc_id"];
  $is_thing = intval($_POST["is_thing"]);
  $thing_id = $_POST["thing_id"];
  $is_mem = intval($_POST["is_mem"]);
  $mem_id = $_POST["mem_id"];
  $is_score = intval($_POST["is_score"]);
  $min_score = intval($_POST["min_score"]);
  $sql = "insert into BADGE values (badge_seq.nextval, '$name', '$score', '$detail', $is_loc, $is_tim, $is_mem, $is_pos, $is_thing, $is_score, $min_score)";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);

  if ($r) {
    $suc = 1;
    if ($is_loc) {
      foreach ($loc_id as $id) {
        $sql = "insert into BADGE_LOCATION values (badge_seq.currval, $id)";
        $stid = oci_parse($db_conn, $sql);
        $r = oci_execute($stid);
        if (!$r) {
          $e = oci_error($stid);
          $result["status"] = "failed";
          $result["data"] .= "(loc) ".$e["message"]."\n";
          $suc = 0;
        }
      }
    }
    if ($is_pos) {
      foreach ($pos_id as $id) {
        $sql = "insert into BADGE_POSTURE values (badge_seq.currval, $id)";
        $stid = oci_parse($db_conn, $sql);
        $r = oci_execute($stid);
        if (!$r) {
          $e = oci_error($stid);
          $result["status"] = "failed";
          $result["data"] .= "(pos) ".$e["message"]."\n";
          $suc = 0;
        }
      }
    }
    if ($is_tim) {
      foreach ($tim_id as $id) {
        $sql = "insert into BADGE_TIMING values (badge_seq.currval, $id)";
        $stid = oci_parse($db_conn, $sql);
        $r = oci_execute($stid);
        if (!$r) {
          $e = oci_error($stid);
          $result["status"] = "failed";
          $result["data"] .= "(tim) ".$e["message"]."\n";
          $suc = 0;
        }
      }
    }
    if ($is_mem) {
      foreach ($mem_id as $id) {
        $sql = "insert into BADGE_MEMBER values (badge_seq.currval, $id)";
        $stid = oci_parse($db_conn, $sql);
        $r = oci_execute($stid);
        if (!$r) {
          $e = oci_error($stid);
          $result["status"] = "failed";
          $result["data"] .= "(mem) ".$e["message"]."\n";
          $suc = 0;
        }
      }
    }
    if ($is_thing) {
      foreach ($thing_id as $id) {
        $sql = "insert into BADGE_THING values (badge_seq.currval, $id)";
        $stid = oci_parse($db_conn, $sql);
        $r = oci_execute($stid);
        if (!$r) {
          $e = oci_error($stid);
          $result["status"] = "failed";
          $result["data"] .= "(thing) ".$e["message"];
          $suc = 0;
        }
      }
    }
    if ($suc) {
      $target_dir = $CONFIG["path"]["root"]."/".$CONFIG["image"]["badge"];

      $stid = oci_parse($db_conn, "SELECT * FROM BADGE where name='$name'");
      oci_execute($stid);
      $row = oci_fetch_assoc($stid);
      $id = $row['ID'];

      $up = 1;
      $logo_type = getFileType($_FILES["badge_pic"]["name"]);
      $ex_type = getFileType($_FILES["ex_pic"]["name"]);

      if (in_array($logo_type, $CONFIG["upload"]["type"]) && in_array($ex_type, $CONFIG["upload"]["type"])) {
        $logo = $target_dir."logo_".$id.".".$logo_type;
        $ex = $target_dir."ex_".$id.".".$ex_type;
        if (!move_uploaded_file($_FILES["badge_pic"]["tmp_name"],$logo)) {
          $up = 0;
        }
        if (!move_uploaded_file($_FILES["ex_pic"]["tmp_name"],$ex)) {
          $up = 0;
        }
      } else {
        $up = 0;
      }

      if ($up) {
        $result["status"] = "success";
        $result["data"] = "";
      } else {
        $result["status"] = "failed";
        $result["data"] = "Upload image Error";
      }
    }
  } else {
    $e = oci_error($stid);
    $result["status"] = "failed";
    $result["data"] = "(Main) ".$e["message"];
  }
} else {
  $table_name = strtoupper($option);
  $curr_table = array("LOCATION", "TIMING", "POSTURE", "THING");
  if (in_array($table_name, $curr_table)) {
    $name = $_POST["name"];
    $detail = $_POST["detail"];

    $sql = "insert into $table_name values (".$option."_seq.nextval, '$name', '$detail')";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);

    if ($r) {
      $target_dir = $CONFIG["path"]["root"]."/".$CONFIG["image"][$option];

      $stid = oci_parse($db_conn, "SELECT * FROM $table_name where name='$name'");
      oci_execute($stid);
      $row = oci_fetch_assoc($stid);
      $id = $row['ID'];

      $up = 1;

      $type = getFileType($_FILES["ex_pic"]["name"]);
      if (in_array($type, $CONFIG["upload"]["type"])) {
        $ex = $target_dir.$id.".".$type;
        if (!move_uploaded_file($_FILES["ex_pic"]["tmp_name"],$ex)) {
          $up = 0;
        }
      } else {
        $up = 0;
      }

      if ($up) {
        $result["status"] = "success";
        $result["data"] = "";
      } else {
        $result["status"] = "failed";
        $result["data"] = "Upload image Error";
      }
    } else {
      $e = oci_error($stid);
      $result["status"] = "failed";
      $result["data"] = $e["message"];
    }
  } else {
    $result["status"] = "failed";
    $result["data"] = "Wrong Option";
  }
}

echo json_encode($result);
?>
