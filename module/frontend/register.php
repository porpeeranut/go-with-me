<?php
include_once "../../config.inc.php";
include_once($CONFIG["inc"]["connect"]);
include_once($CONFIG["inc"]["function"]);

$username = clean($_POST["user"]);
$password = md5($_POST["pass"]);
$repass = md5($_POST["repass"]);
$name = clean($_POST["name"]);
$email = clean($_POST["email"]);
$all_score = 0;
$image = $_FILES["image"];
$profile = getFileType($image["name"]);

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
  $sql = "insert into MEMBER values (member_seq.nextval, '$username', '$password', '$name', '$email', $all_score, '$profile')";
  $stid = oci_parse($db_conn, $sql);
  $r = oci_execute($stid);
  if ($r) {
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
    $result["data"] = "Can't Register";
  }
}

echo json_encode($result);

?>
