<?php
/*
  person lookup, then show the rosters for that person, with links
*/
require_once 'libe.php';
require_once 'objects.php';

//$_POST["alum_id"]=695;

/* alum_id is the person being looked up
   user_id is the person logged in */
if(isset($_POST["alum_id"])) {
  $alum_id=$_POST["alum_id"];
  $alum=new UserData($msi,$smarty,$user_id,$alum_id);
  if(count($alum->ud) > 0) {
    /* confusing - smarty variable should be alum, but
       display_user needs it to be user */
    $smarty->assign('user',$alum);
    $smarty->assign('contact',new ContactData($msi,$smarty,
       $user_id,$alum_id));
    $tr=new RosterData($msi,$smarty,$alum_id);
    $smarty->assign('alum_name',$alum->ud['first_name']['v'].' '.
      (strlen(trim($alum->ud['middle_name']['v'])) > 0 ?
                   $alum->ud['middle_name']['v'].' ' : '').
      $alum->ud['primary_name']['v']);
    $smarty->assign('roster',$tr);
    $smarty->assign('rostercount',$tr->roster_count);
  }
}
else {
  $smarty->assign('alum_name',$_GET['alum_name']);
}

$smarty->assign('referrer','people');
$smarty->display('people.tpl');
EOT;

?>
