<?php

/*
  person lookup, then show the rosters for that person, with links
*/

require_once 'libe.php';
require_once 'objects.php';

$smarty->assign('is_contact_viewer',
  $rbac->Users->hasRole('Contact Information Viewer',$user_id));
$smarty->assign('is_contact_editor',
  $rbac->Users->hasRole('Contact Information Editor',$user_id));

if(isset($_GET["alum_id"])) {
  $alum_id=$_GET["alum_id"];
  $smarty->assign('user',new UserData($msi,$smarty,$alum_id));
  $smarty->assign('contact',new ContactData($msi,$smarty,$alum_id));
  $tr=new RosterData($msi,$smarty,$alum_id);
  $smarty->assign('roster',$tr);
  $smarty->assign('rostercount',$tr->roster_count);
}
$smarty->assign('page_request','people');
$smarty->display('people.tpl');

?>
