<?php
/* setnewpw - set password for PHP password_hash & password_verify
   call with php setnewpw.php <username> <password> */
require_once 'libe.php';

$contact_id=$argv[1];
$pwhash=password_hash($argv[2],PASSWORD_DEFAULT);

if(!$msi->query("update contacts set password='$pwhash',".
    "password_reset=0 where contact_id='$contact_id'")) {
  echo 'Set password query failed: '.$msi->error;
}

?>
