<?php
$db_conn = oci_connect($CONFIG["database"]["username"], $CONFIG["database"]["password"], $CONFIG["database"]["host"]."/".$CONFIG["database"]["sid"]);
if (!$db_conn) {
  $result["status"] = "failed";
  $result["message"] = "Database Connection Error";
  echo json_encode($result);
  exit;
}
?>
