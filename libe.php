<?php

require_once 'vendor/autoload.php';

$smarty = new Smarty();
$smarty->addTemplateDir(__DIR__ . '/templates');
$smarty->addPluginsDir(__DIR__ . '/plugins');
$rbac = new PhpRbac\Rbac();

// database connection
include 'config.php';
$msi = new mysqli($db_host, $db_user, $db_pw, $db_db);

function o_session() {
  // if there is a session, return user code, else 0 to indicate no session
  session_start();
  if(isset($_SESSION['contact_id'])) {
    return $_SESSION['contact_id'];
  }
  else {
    return 0;
  }
}
require 'objects.php';
?>