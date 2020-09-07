<?php
/* home.php */

require_once 'libe.php';
require_once 'objects.php';

$smarty->assign('user',new UserData($msi,$smarty,$user_id,$user_id));
$smarty->assign('contact',new ContactData($msi,$smarty,
  $user_id,$user_id));
$tr=new RosterData($msi,$smarty,$user_id);
$smarty->assign('roster',$tr);
$smarty->assign('rostercount',$tr->roster_count);
$smarty->assign('referrer','home');
$smarty->display('home.tpl');

?>
