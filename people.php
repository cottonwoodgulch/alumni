<?php

/*
  person lookup, then show the rosters for that person, with links
*/

require_once 'libe.php';
require_once 'objects.php';

/* alum_id is the person being looked up
   user_id is the person logged in */
if(isset($_GET["alum_id"])) {
  $alum_id=$_GET["alum_id"];
  $smarty->assign('user',new UserData($msi,$smarty,
     $user_id,$alum_id));
  $smarty->assign('contact',new ContactData($msi,$smarty,
     $user_id,$alum_id));
  $tr=new RosterData($msi,$smarty,$alum_id);
  $smarty->assign('roster',$tr);
  $smarty->assign('rostercount',$tr->roster_count);
}
$smarty->display('people.tpl');

?>
