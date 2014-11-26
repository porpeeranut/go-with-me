<?php
$username = clean($_POST["username"]);
$password = md5($_POST["password"]);
$repass = md5($_POST["repass"]);
$name = clean($_POST["name"]);
$email = clean($_POST["email"]);
$all_score = 0;
$image = $_FILES["image"];
$profile = getFileType($image["name"]);

$result["status"] = "failed";
if (strlen($username)<=4 || strlen($_POST["password"])<=4) {
  $result["data"] = "Username or Password should be longer than 4 character";
}
else if ($password!=$repass) {
  $result["data"] = "Re-Password or Password Wrong";
}
else if (email($email)) {
  $result["data"] = "Email Wrong Format";
}
else if (!in_array($logo_type, $CONFIG["upload"]["type"])) {
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
    $im = $target_di.$id.".".$profile;
    if (!move_uploaded_file($image["tmp_name"], $im)) {
      $result["data"] = "Image Error";
    } else {
      $result["statue"] = "success";
      $result["data"] = "";
    }
  } else {
    $result["data"] = "Can't Register";
  }
}

echo json_encode($result);

?>
