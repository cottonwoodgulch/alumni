<?php

require_once 'vendor/autoload.php';

$smarty = new Smarty();
$smarty->addTemplateDir(__DIR__ . '/templates');
$smarty->addPluginsDir(__DIR__ . '/plugins');
$rbac = new PhpRbac\Rbac();

/* PHP requires setting a timezone. This will be fine,
   since the app doesn't require a time */
date_default_timezone_set('America/New_York');

// database connection
include 'config.php';
$msi = new mysqli($db_host, $db_user, $db_pw, $db_db);

session_start();
if(isset($_SESSION['user_id'])) {
  $user_id=$_SESSION['user_id'];
  $smarty->assign('HelloName',$_SESSION['HelloName']);
}
else {
  $user_id=0;
  if(!isset($login)) {
    header("Location: login.php");
  }
}

function displayFooter($smarty,$message) {
  /* footer will display if the smarty variable footer is set */
  $msg='<table><tr>
    <td class="footermsg">'.$message.
    '</td><td class="footermsg"><button type="button" '.
    'onClick="hideFooter();">Close</button></td></tr></table>';
  $smarty->assign('footer',$msg);
}
?>
