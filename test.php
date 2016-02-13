<?php


require_once 'libe.php';
echo 'pre phpass';
$phpass = new PasswordHash(12,false);
echo 'post phpass';

?>