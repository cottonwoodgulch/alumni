<?php

/*
  person lookup, then show the rosters for that person, with links
*/

require_once 'libe.php';
require_once 'objects.php';

$cid=o_session();
/* if there is a contact_id stored in $_SESSION, we assume user has successfully logged in */
if(!$cid) {
  header("Location: login.php");
  exit;
}
$smarty->assign('HelloName',$_SESSION['HelloName']);
/* rbac on www.cottonwoodgulch.org can't look up a role_id by name
$smarty->assign('is_contact_viewer',
  $rbac->Users->hasRole('Contact Information Viewer',$cid));
$smarty->assign('is_contact_editor',
  $rbac->Users->hasRole('Contact Information Editor',$cid));*/
$smarty->assign('is_contact_viewer',$rbac->Users->hasRole(5,$cid));
$smarty->assign('is_contact_editor',$rbac->Users->hasRole(4,$cid));

if(isset($_GET["alum_id"])) {
  $alum_id=$_GET["alum_id"];
  $smarty->assign('user',new UserData($msi,$smarty,$alum_id));
  $smarty->assign('contact',new ContactData($msi,$smarty,$alum_id));
  $tr=new RosterData($msi,$smarty,$alum_id);
  $smarty->assign('roster',$tr);
  $smarty->assign('rostercount',$tr->roster_count);
}
$smarty->display('people.tpl');

?>
