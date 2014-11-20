<?php
function errorcode2string($err_code) {
  return $err[$err_code];
}

function getFileType($name) {
  return strtolower(end(explode('.', $name)));
}

?>
