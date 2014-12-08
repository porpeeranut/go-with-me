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
  return !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

?>
