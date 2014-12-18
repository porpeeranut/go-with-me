<?php
include_once "../../config.inc.php";
include_once($CONFIG["inc"]["connect"]);
include_once($CONFIG["inc"]["function"]);

$option = $_GET["option"];
$table_name = strtoupper($option);

session_start();
if ($table_name!="REGISTER" and (!isset($_SESSION["login"]) || $_SESSION["login"]!="true")) {
  echo "Fuck You!!!!!";
  exit;
}

if ($table_name!="REGISTER") $m_id = $_SESSION["id"];

if ($table_name=="REGISTER") {

  $im = 0;
  if (isset($_FILES["image"])) $im=1;

  $username = clean($_POST["user"]);
  $password = md5($_POST["pass"]);
  $repass = md5($_POST["repass"]);
  $name = clean($_POST["name"]);
  $email = clean($_POST["email"]);
  $all_score = 0;
  if ($im) {
    $image = $_FILES["image"];
    $profile = getFileType($image["name"]);
  } else {
    $profile = "no";
  }

  $result["status"] = "failed";
  if (strlen($username)<=4 || strlen($_POST["pass"])<=4) {
    $result["data"] = "Username and Password should be longer than 4 character";
  }
  else if ($password!=$repass) {
    $result["data"] = "Re-Password or Password is Wrong";
  }
  else if (email($email)) {
    $result["data"] = "Email Wrong Format";
  }
  else if (!in_array($profile, $CONFIG["upload"]["type"])) {
    $result["data"] = "Dont Correct data type of image";
  } else {
    $sql = "insert into MEMBER values (member_seq.nextval, '$username', '$password', '$name', '$email', $all_score, '$profile', 'f')";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    if ($r) {
      if ($im) {
        $stid = oci_parse($db_conn, "SELECT * FROM member where username='$username'");
        oci_execute($stid);
        $row = oci_fetch_assoc($stid);
        $id = $row['ID'];

        $target_dir = $CONFIG["path"]["root"]."/".$CONFIG["image"]["member"];
        $im = $target_dir.$id.".".$profile;
        if (!move_uploaded_file($image["tmp_name"], $im)) {
          $result["data"] = "Image Error";
        } else {
          $result["status"] = "success";
          $result["data"] = "";
        }
      } else {
        $result["status"] = "success";
        $result["data"] = "";
      }
    } else {
      $result["data"] = "Can't Register";
    }
  }
}
else if ($table_name=="PHOTO") {

  if (!isset($_POST["caption"]) || !isset($_FILES["pic"]) || $_POST["caption"]=="") {
    $result["status"] = "failed";
    $result["data"] = "Invaid Value.";
    echo json_encode($result);
    exit;
  }

  $caption = clean($_POST["caption"]);
  $owner = intval($m_id);
  $loc_id = intval($_POST["loc_id"]);
  $timing_id = intval($_POST["timing_id"]);
  $pos_id = intval($_POST["pos_id"]);
  $thing_id = intval($_POST["thing_id"]);
  $is_tag = 0;
  if ($_POST["tag"]!="0") {
    $tag = explode(",",$_POST["tag"]);
    $is_tag = 1;
  }

  $image = $_FILES["pic"];
  $profile = getFileType($image["name"]);



  $sql = "insert into PHOTO values (photo_seq.nextval, '$caption', $owner, $loc_id, $timing_id, $pos_id, $thing_id, systimestamp, '$profile')";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);

  if ($r) {

    $stid = oci_parse($db_conn, "SELECT photo_seq.currval FROM dual");
    oci_execute($stid);
    $row = oci_fetch_assoc($stid);
    $id = intval($row["CURRVAL"]);
    if ($is_tag) {
      foreach($tag as $t) {
        $sql = "insert into TAG values ($t, $id)";
        $stid = oci_parse($db_conn, $sql);
        $r = oci_execute($stid);
      }
    }

    $sql = "select * from badge where ID not in (select BADGE_ID from BADGE_COLLECT where MEMBER_ID=$m_id)";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    $nb = oci_fetch_all($stid, $badge, null, null, OCI_FETCHSTATEMENT_BY_ROW);

    $sql = "select p.THING_ID, p.LOC_ID, p.TIMING_ID, p.POS_ID from PHOTO p where p.OWNER_ID=$m_id";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    oci_fetch_all($stid, $photo, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);

    $sql = "select M_ID from TAG where P_ID in (select ID from PHOTO where OWNER_ID=$m_id)";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    oci_fetch_all($stid, $tag, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);

    if ($is_tag) $photo["M_ID"] = $tag["M_ID"];
    else $photo["M_ID"] = array();


    $stid = oci_parse($db_conn, "SELECT photo_seq.currval FROM dual");
    oci_execute($stid);
    $row = oci_fetch_assoc($stid);
    $id = intval($row["CURRVAL"]);

    $target_dir = $CONFIG["path"]["root"]."/".$CONFIG["image"]["photo"];
    $im = $target_dir.$id.".".$profile;
    if (!move_uploaded_file($image["tmp_name"], $im)) {
      $result["data"] = "Image Error";
    } else {
      $result["status"] = "success";
      $result["data"] = "";
    }

    $result["data"] = array();
    $score = 0;
    foreach($badge as $row) {
      $id = $row["ID"];
      $sc = $row["SCORE"];
      $sql = "select THING_ID from BADGE_THING where BADGE_ID=$id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      $nb = oci_fetch_all($stid, $thing, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);

      $sql = "select MEMBER_ID from BADGE_MEMBER where BADGE_ID=$id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      $nb = oci_fetch_all($stid, $member, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);

      $sql = "select TIMING_ID from BADGE_TIMING where BADGE_ID=$id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      $nb = oci_fetch_all($stid, $timing, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);

      $sql = "select POSTURE_ID from BADGE_POSTURE where BADGE_ID=$id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      $nb = oci_fetch_all($stid, $posture, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);

      $sql = "select LOCATION_ID from BADGE_LOCATION where BADGE_ID=$id";
      $stid = oci_parse($db_conn, $sql);
      $r = oci_execute($stid);
      $nb = oci_fetch_all($stid, $location, null, null, OCI_FETCHSTATEMENT_BY_COLUMN);

      if (array_intersect($thing["THING_ID"], $photo["THING_ID"]) == $thing["THING_ID"] and
          array_intersect($member["MEMBER_ID"], $photo["M_ID"]) == $member["MEMBER_ID"] and
          array_intersect($timing["TIMING_ID"], $photo["TIMING_ID"]) == $timing["TIMING_ID"] and
          array_intersect($posture["POSTURE_ID"], $photo["POS_ID"]) == $posture["POSTURE_ID"] and
          array_intersect($location["LOCATION_ID"], $photo["LOC_ID"]) == $location["LOCATION_ID"]) {

        array_push($result["data"], $row);
        $score+=$sc;
        $sql = "insert into BADGE_COLLECT values ($id, $m_id)";
        $stid = oci_parse($db_conn, $sql);
        $r = oci_execute($stid);
      }
    }
    $sql = "update MEMBER set ALL_SCORE=ALL_SCORE+$score where ID=$m_id";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    $result["status"] = "success";
  } else {
    $e = oci_error($stid);
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
}
else if ($table_name=="COMMENT") {
  $msg = clean($_POST["msg"]);
  $p_id = intval($_POST["p_id"]);

  $sql = "insert into COMMENT_PHOTO values (comment_photo_seq.nextval, $m_id, $p_id, '$msg', systimestamp)";
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
else if ($table_name=="LIKE") {
  $p_id = intval($_POST["p_id"]);
  $sql = "insert into LIKE_PHOTO values ($m_id, $p_id)";
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
else if ($table_name=="MESSAGE") {
  $to = intval($_GET["to"]);
  $msg = clean($_GET["msg"]);
  $sql = "insert into MESSAGE values (message_seq.nextval, $m_id, $to, '$msg', systimestamp)";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);
  if ($r) {
    $sql = "update MEMBER set IS_UNREAD='t' where ID=$to";
    $stid = oci_parse($db_conn, $sql);
    $r = oci_execute($stid);
    $result["status"] = "success";
    $result["data"] = "";
  } else {
    $e = oci_error($stid);
    $result["status"] = "failed";
    $result["data"] = $e["message"];
  }
}

echo json_encode($result);

?>
