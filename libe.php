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

function displayFooter($smarty,$message) {
  /* footer will display if the smarty variable footer is set */
  $msg='<table><tr>
    <td class="footermsg">'.$message.
    '</td><td class="footermsg"><button type="button" '.
    'onClick="hideFooter();">Close</button></td></tr></table>';
  $smarty->assign('footer',$msg);
}
?>
