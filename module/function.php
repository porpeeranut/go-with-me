<?php
function errorcode2string($err_code) {
  return $err[$err_code];
}

function getFileType($name) {
  return strtolower(end(explode('.', $name)));
}

function clean($variable) {
	$variable = str_replace("'","",$variable);
   return strip_tags(trim($variable));
}

function email($email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return 0;
  }
  return 1;
}

?>
